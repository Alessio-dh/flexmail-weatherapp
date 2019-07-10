<?php
/**
 * Created by PhpStorm.
 * User: alessio
 * Date: 2019-07-08
 * Time: 21:14
 */

namespace App\Service;

use App\Entity\GeolocationEntity;
use Symfony\Component\HttpClient\HttpClient;

class IpGeolocationService
{
    private $apiUrl;
    private $apikey;

    public function __construct()
    {
        //https://ipdata.co/ signup to get api key for free
        $this->apikey = '';
        $this->apiUrl = "https://api.ipdata.co/";
    }


    public function getLocation(?string $ip) : ?GeolocationEntity{
        $geolocation = new GeolocationEntity();

        //Make HTTPS Call to external API for Geolocation identification
        //API => https://ipdata.co/index.html
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', $this->apiUrl.$ip."?api-key=".$this->apikey);

        $statusCode = $response->getStatusCode();
        if($statusCode != "200"){
            $geolocation->setRetrievedSuccess(false);
        }else{
            $content = $response->toArray();

            $geolocation->setRetrievedSuccess(true);
            $geolocation->setLat($content["latitude"]);
            $geolocation->setLng($content["longitude"]);
            $geolocation->setLocationCity($content["city"]);
            $geolocation->setLocationCountry($content["country_name"]);
            $geolocation->setLocationRegion($content["region"]);
        }

        return $geolocation;
    }
}