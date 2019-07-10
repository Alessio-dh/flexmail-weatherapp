<?php
/**
 * Created by PhpStorm.
 * User: alessio
 * Date: 2019-07-08
 * Time: 21:09
 */

namespace App\Entity;


class GeolocationEntity
{
    private $retrievedSuccess;
    private $lat;
    private $lng;
    private $locationCity;
    private $locationCountry;
    private $locationRegion;

    public function getRetrievedSuccess()
    {
        return $this->retrievedSuccess;
    }

    public function setRetrievedSuccess($retrievedSuccess): void
    {
        $this->retrievedSuccess = $retrievedSuccess;
    }

    public function getLocationCity(): ?string
    {
        return $this->locationCity;
    }

    public function getLocationCountry(): ?string
    {
        return $this->locationCountry;
    }

    public function getLocationRegion(): ?string
    {
        return $this->locationRegion;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLat($lat): void
    {
        $this->lat = $lat;
    }

    public function setLng($lng): void
    {
        $this->lng = $lng;
    }

    public function setLocationCity($locationCity): void
    {
        $this->locationCity = $locationCity;
    }

    public function setLocationCountry($locationCountry): void
    {
        $this->locationCountry = $locationCountry;
    }

    public function setLocationRegion($locationRegion): void
    {
        $this->locationRegion = $locationRegion;
    }


}