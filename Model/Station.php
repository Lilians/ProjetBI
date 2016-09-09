<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 09/09/2016
 * Time: 12:40
 */

namespace Model;


class Station
{
    private $number;
    private $contract_name;
    private $name;
    private $address;
    private $position;
    private $banking;
    private $bonus;
    private $status;
    private $bike_stands;
    private $available_bike_stands;
    private $available_bikes;
    private $last_update;

    public static function createStationFromArray($array)
    {
        $S = new Station();
        $S->setNumber($array['number']);
        $S->setContractName($array['contract_name']);
        $S->setName($array['name']);
        $S->setAddress($array['address']);
        $S->setPosition(Position::createPositionFromArray($array['position']));
        $S->setBanking($array['banking']);
        $S->setBonus($array['bonus']);
        $S->setStatus($array['status']);
        $S->setBikeStands($array['bike_stands']);
        $S->setAvailableBikeStands($array['available_bike_stands']);
        $S->setAvailableBikes($array['available_bikes']);
        $S->setLastUpdate($array['last_update']);

        return $S;

    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getContractName()
    {
        return $this->contract_name;
    }

    /**
     * @param mixed $contract_name
     */
    public function setContractName($contract_name)
    {
        $this->contract_name = $contract_name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getBanking()
    {
        return $this->banking;
    }

    /**
     * @param mixed $banking
     */
    public function setBanking($banking)
    {
        $this->banking = $banking;
    }

    /**
     * @return mixed
     */
    public function getBonus()
    {
        return $this->bonus;
    }

    /**
     * @param mixed $bonus
     */
    public function setBonus($bonus)
    {
        $this->bonus = $bonus;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getBikeStands()
    {
        return $this->bike_stands;
    }

    /**
     * @param mixed $bike_stands
     */
    public function setBikeStands($bike_stands)
    {
        $this->bike_stands = $bike_stands;
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