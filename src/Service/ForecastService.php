<?php
/**
 * Created by PhpStorm.
 * User: alessio
 * Date: 2019-07-08
 * Time: 22:00
 */

namespace App\Service;


use App\Entity\ForecastItemEntity;
use App\Entity\GeolocationEntity;
use DmitryIvanov\DarkSkyApi\DarkSkyApi;


class ForecastService
{
    private $apiKey;

    public function __construct()
    {
        //https://darksky.net/dev signup to get api key for free
        $this->apiKey = '';
    }

    public function getForecast(GeolocationEntity $geolocation){
        $forecast = (new DarkSkyApi($this->apiKey))
            ->location($geolocation->getLat(),$geolocation->getLng())
            ->units('ca')
            ->language('en')
            ->forecast(['currently', 'daily']);


        $items = $forecast->daily()->data();
        $newForecastItemList = array();
        foreach ($items as $item){
            $date = date('d-m-Y H:i:s',$item->time());
            if($this->isYesterday($date)){
                continue;
            }
            $newForecastItem = new ForecastItemEntity();
            $newForecastItem->setDate($date);
            $newForecastItem->setIcon($item->icon());
            $newForecastItem->setMaxtemp($item->temperatureHigh());
            $newForecastItem->setMintemp($item->apparentTemperatureLow());
            $newForecastItem->setPerception($item->precipProbability());
            $newForecastItem->setWindspeed(round($item->windSpeed(),2));
            $newForecastItem->setWinddirection($this->getWindDirection($item->windBearing()));
            if($this->isToday($date)){
                $newForecastItem->setIsToday(true);
                $newForecastItem->setCurrentTemp(round($item->temperature(),0));
            }else{
                $newForecastItem->setIsToday(false);
                $newForecastItem->setCurrentTemp(0);

            }

            $newForecastItemList[] = $newForecastItem;
        }
        return $newForecastItemList;
    }

    private function getWindDirection($bearing)
    {
        $cardinalDirections = array(
            array('North', 337.5, 360),
            array('North', 0, 22.5),
            array('North-East', 22.5, 67.5),
            array('East', 67.5, 112.5),
            array('South-East', 112.5, 157.5),
            array('South', 157.5, 202.5),
            array('South-West', 202.5, 247.5),
            array('West', 247.5, 292.5),
            array('North-West', 292.5, 337.5),
            array('North', 292.5, 337.5),
        );

        $count = count($cardinalDirections);

        for ($i = 0; $i < $count; $i++) {
            if ($bearing >= $cardinalDirections[$i][1] && $bearing < $cardinalDirections[$i][2]) {
                $direction = $cardinalDirections[$i][0];
                $i = $count;
            }
        }

        return $direction;
    }

    private function isToday($date) //check if it's today
    {
        if(date('Ymd') == date('Ymd', strtotime($date)))
            return true;
        else
            return false;
    }

    private function isYesterday($date) //check if it's yesterday
    {
        $now = time();
        if(strtotime($date) < strtotime(date('Ymd')))
            return true;
        else
            return false;
    }
}