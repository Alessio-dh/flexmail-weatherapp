<?php

namespace App\Controller;

use App\Entity\HistoryEntity;
use App\Entity\ForecastItemEntity;
use App\Service\ForecastService;
use App\Service\HistoryService;
use App\Service\IpGeolocationService;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Faker\Factory;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(\Symfony\Component\HttpFoundation\Request $request,IpGeolocationService $geolocationService,ForecastService $forecastService)
    {
        date_default_timezone_set('Europe/Brussels');

        $ip = $request->getClientIp();

        //If on local environment you should hard code the IP address due to an 127.0.0.1 not being available as a legit address
        //$ip = "xx.xx.xx.xx";

        //Auto detect location based on IP address
        $geolocation = $geolocationService->getLocation($ip);

        if(!$geolocation->getRetrievedSuccess()){

            //Location failed to retreive , give error message + dummy data for uknown locations and weather data
            $this->get('session')->getFlashBag()->clear();
            $this->addFlash('error',"We couldn't find you location based on your IP address , are you using a proxy or VPN?");

            $forecasts = array();

            for($i = 0 ; $i < 8;$i++)
            {
                $newForecastItem = new ForecastItemEntity();
                $newForecastItem->setDate(date('d-M-Y'));
                $newForecastItem->setIcon('question_mark');
                $newForecastItem->setMaxtemp(0);
                $newForecastItem->setMintemp(0);
                $newForecastItem->setPerception(0);
                $newForecastItem->setWindspeed(0);
                $newForecastItem->setWinddirection('Unknown');
                if($i === 0){
                    $newForecastItem->setIsToday(true);
                }else{
                    $newForecastItem->setIsToday(false);

                }
                $newForecastItem->setCurrentTemp(0);
                $forecasts[] = $newForecastItem;
            }
        }else{
            //All good get forecast data
            $forecasts = $forecastService->getForecast($geolocation);
        }

        //Show all data that has been processed
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'geolocation' => $geolocation,
            'forecasts' => $forecasts
        ]);
    }

    /**
     * @Route("/history", name="history")
     */
    public function history(\Symfony\Component\HttpFoundation\Request $request,IpGeolocationService $geolocationService,HistoryService $historyService)
    {
        //we will go 30 days back in time
        $ip = $request->getClientIp();

        //If on local environment you should hard code the IP address due to an 127.0.0.1 not being available as a legit address
        //$ip = "xx.xx.xx.xx";

        //Auto detect on first entry (because we do not know where the user is from, base location on IP address) :D
        $geolocation = $geolocationService->getLocation($ip);

        $histories = array();

        //Auto detect location based on IP address
        if (!$geolocation->getRetrievedSuccess()) {

            //Location failed to retreive , give error message + dummy data for uknown locations and weather data
            $this->get('session')->getFlashBag()->clear();
            $this->addFlash('error', "We couldn't find you location based on your IP address , are you using a proxy or VPN?");

            $allNeededdates = [];
            for ($i = 30; $i > 0; $i--) {
                $allNeededdates[] = date('Y-m-d', strtotime('-' . $i . ' days'));
            }

            foreach ($allNeededdates as $date => $i) {
                $newHistory = new HistoryEntity();
                $newHistory->setIcon('question_mark');
                $newHistory->setMaxtemp(0);
                $newHistory->setMintemp(0);
                $newHistory->setDate(date('d-M-Y'));
                $histories[] = $newHistory;
            }
        } else {
            //All good get history data
            $histories = $historyService->getHistory($geolocation);
        }

        //Show all data that has been processed
        return $this->render('history/history.html.twig', [
            'controller_name' => 'HomeController',
            'geolocation' => $geolocation,
            'histories' => $histories
        ]);
    }
}
