<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 09/09/2016
 * Time: 12:40
 */

namespace Model;

include 'Arrondissement.php';
include 'StationSnapshot.php';

class Station
{
    private $number;
    private $contract_name;
    private $name;
    private $city;
    private $arrondissement;
    private $address;
    private $position;
    private $banking;
    private $bonus;
    private $status;
    private $bike_stands;
    private $snapshots;

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
        $S->setCity($c = new City($array['city']));
        $S->setArrondissement(new Arrondissement($array['arrondissement'], $c));


        $S->snapshots = [];
        $snapshot =  StationSnapshot::createStationSnapshotFromArray($array);
        $S->snapshots[] = $snapshot;
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
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getArrondissement()
    {
        return $this->arrondissement;
    }

    /**
     * @param mixed $arrondissement
     */
    public function setArrondissement($arrondissement)
    {
        $this->arrondissement = $arrondissement;
    }

    /**
     * @return mixed
     */
    public function getSnapshots()
    {
        return $this->snapshots;
    }

    /**
     * @param mixed $snapshots
     */
    public function setSnapshots($snapshots)
    {
        $this->snapshots = $snapshots;
    }

}