<?php
/**
 * Created by PhpStorm.
 * User: alessio
 * Date: 2019-07-08
 * Time: 22:25
 */

namespace App\Entity;


class ForecastItemEntity
{
    private $maxtemp;
    private $mintemp;
    private $date;
    private $icon;
    private $perception;
    private $windspeed;
    private $winddirection;
    private $isToday;
    private $currentTemp;

    public function getCurrentTemp()
    {
        return $this->currentTemp;
    }

    public function setCurrentTemp($currentTemp): void
    {
        $this->currentTemp = $currentTemp;
    }

    public function getisToday()
    {
        return $this->isToday;
    }

    public function setIsToday($isToday): void
    {
        $this->isToday = $isToday;
    }

    public function getMaxtemp()
    {
        return $this->maxtemp;
    }

    public function setMaxtemp($maxtemp): void
    {
        $this->maxtemp = $maxtemp;
    }

    public function getMintemp()
    {
        return $this->mintemp;
    }

    public function setMintemp($mintemp): void
    {
        $this->mintemp = $mintemp;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon($icon): void
    {
        $this->icon = $icon;
    }

    public function getPerception()
    {
        return $this->perception;
    }

    public function setPerception($perception): void
    {
        $this->perception = $perception*100;
    }

    public function getWindspeed()
    {
        return $this->windspeed;
    }

    public function setWindspeed($windspeed): void
    {
        $this->windspeed = $windspeed;
    }

    public function getWinddirection()
    {
        return $this->winddirection;
    }

    public function setWinddirection($winddirection): void
    {
        $this->winddirection = $winddirection;
    }

}