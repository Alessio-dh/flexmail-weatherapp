<?php
/**
 * Created by PhpStorm.
 * User: alessio
 * Date: 2019-07-09
 * Time: 12:06
 */

namespace App\Entity;


class HistoryEntity
{
    private $date;
    private $maxtemp;
    private $mintemp;
    private $icon;

    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon($icon): void
    {
        $this->icon = $icon;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): void
    {
        $this->date = $date;
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


}