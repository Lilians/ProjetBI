<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 10/09/2016
 * Time: 13:32
 */

namespace Model;


class StationSnapshot
{
    private $id;
    private $station_number;
    private $available_bike_stands;
    private $available_bikes;
    private $last_update;

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

    /**
     * @return mixed
     */
    public function getStationNumber()
    {
        return $this->station_number;
    }

    /**
     * @param mixed $station_number
     */
    public function setStationNumber($station_number)
    {
        $this->station_number = $station_number;
    }

    /**
     * @return mixed
     */
    public function getAvailableBikeStands()
    {
        return $this->available_bike_stands;
    }

    /**
     * @param mixed $available_bike_stands
     */
    public function setAvailableBikeStands($available_bike_stands)
    {
        $this->available_bike_stands = $available_bike_stands;
    }

    /**
     * @return mixed
     */
    public function getAvailableBikes()
    {
        return $this->available_bikes;
    }

    /**
     * @param mixed $available_bikes
     */
    public function setAvailableBikes($available_bikes)
    {
        $this->available_bikes = $available_bikes;
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




}