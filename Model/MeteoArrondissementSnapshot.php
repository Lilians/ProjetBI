<?php

namespace Model;


class MeteoArrondissementSnapshot
{
    private $id;
    private $arrondissement;
    private $last_time;
    private $last_update;
    private $summary;
    private $temperature;
    private $apparent_emperature;
    private $humidity;
    private $cloud_cover;
    private $wind_speed;
    private $wind_bearing;
    private $precip_intensity;
    private $precip_probability;
    
    public function __construct()
    {
    }

    public static function createMeteoArrondissementSnapshotFromArray(Arrondissement $arr, $array)
    {
        $Snap = new MeteoArrondissementSnapshot();
        $Snap->setArrondissement($arr);
        $Snap->setLastTime( date('Y-m-d H:i:s', $array['currently']['time']));
        $Snap->setLastUpdate( date('Y-m-d H:i:s'));
        $Snap->setSummary($array['currently']['summary']);
        $Snap->setTemperature(($array['currently']['temperature']-32)*(5/9));
        $Snap->setCloudCover($array['currently']['cloudCover']);
        $Snap->setHumidity($array['currently']['humidity']);
        $Snap->setPrecipIntensity($array['currently']['precipIntensity']);
        $Snap->setPrecipProbability($array['currently']['precipProbability']);
        $Snap->setWindBearing($array['currently']['windBearing']);
        $Snap->setWindSpeed($array['currently']['windSpeed']*1.609344);
        $Snap->setApparentEmperature(($array['currently']['apparentTemperature']-32)*(5/9));
        return $Snap;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
        
    }
    function getArrondissement()
    {
        return $this->arrondissement;
    }

    function setArrondissement($arrondissement)
    {
        $this->arrondissement = $arrondissement;
    }

       
    /**
     * @return mixed
     */
    public function getLastUpdate()
    {
        return $this->last_update;
    }

    /**
     * @param mixed $last_update
     */
    public function setLastUpdate($last_update)
    {
        $this->last_update = $last_update;
    }
    
    function getLastTime()
    {
        return $this->last_time;
    }

    function setLastTime($last_time)
    {
        $this->last_time = $last_time;
    }

    function getSummary()
    {
        return $this->summary;
    }

    function getTemperature()
    {
        return $this->temperature;
    }

    function setSummary($summary)
    {
        $this->summary = $summary;
    }

    function setTemperature($temperature)
    {
        $this->temperature = $temperature;
    }

    function getApparentTemperature()
    {
        return $this->apparent_emperature;
    }

    function getHumidity()
    {
        return $this->humidity;
    }

    function getCloudCover()
    {
        return $this->cloud_cover;
    }

    function getWindSpeed()
    {
        return $this->wind_speed;
    }

    function getWindBearing()
    {
        return $this->wind_bearing;
    }

    function getPrecipIntensity()
    {
        return $this->precip_intensity;
    }

    function getPrecipProbability()
    {
        return $this->precip_probability;
    }

    function setApparentEmperature($apparent_emperature)
    {
        $this->apparent_emperature = $apparent_emperature;
    }

    function setHumidity($humidity)
    {
        $this->humidity = $humidity;
    }

    function setCloudCover($cloud_cover)
    {
        $this->cloud_cover = $cloud_cover;
    }

    function setWindSpeed($wind_speed)
    {
        $this->wind_speed = $wind_speed;
    }

    function setWindBearing($wind_bearing)
    {
        $this->wind_bearing = $wind_bearing;
    }

    function setPrecipIntensity($precip_intensity)
    {
        $this->precip_intensity = $precip_intensity;
    }

    function setPrecipProbability($precip_probability)
    {
        $this->precip_probability = $precip_probability;
    }




}