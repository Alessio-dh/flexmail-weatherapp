<?php
/**
 * Created by PhpStorm.
 * User: alessio
 * Date: 2019-07-09
 * Time: 11:56
 */

namespace App\Service;


use App\Entity\GeolocationEntity;
use App\Entity\HistoryEntity;
use DmitryIvanov\DarkSkyApi\DarkSkyApi;

class HistoryService
{
    private $apiKey;

    public function __construct()
    {
        //https://darksky.net/dev signup to get api key for free
        $this->apiKey = '';
    }

    public function getHistory(GeolocationEntity $geolocation){
        $allNeededdates = [];
        for($i=30;$i>0;$i--){
            $allNeededdates[] = date('Y-m-d', strtotime('-'.$i.' days'));
        }

        //These calls are made concurrently
        $histories = (new DarkSkyApi($this->apiKey))
            ->location($geolocation->getLat(),$geolocation->getLng())
            ->units('ca')
            ->language('en')
            ->timeMachine($allNeededdates,['daily']);

        $newHistoryListToReturn = array();
        foreach ($histories as $date => $history){
            $historyEntity = new HistoryEntity();
            $historyEntity->setDate($date);
            $historyEntity->setMintemp($history->daily()->temperatureLow());
            $historyEntity->setMaxtemp($history->daily()->temperatureHigh());
            $historyEntity->setIcon($history->daily()->icon());
            $newHistoryListToReturn[] = $historyEntity;
        }

        return $newHistoryListToReturn;
    }
}