<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 10/09/2016
 * Time: 13:28
 */

namespace Model;


use DAO\DAO;

class Arrondissement
{
    private $id;
    private $name;
    private $city;
    private $latitude;
    private $longitude;

    
    /**
     * Arrondissement constructor.
     * @param $name
     * @param City $city
     * @param float $lat
     * @param float $lng
     */
    public function __construct($name, City $city, $lat=0.0, $lng=0.0)
    {
        $this->name = $name;
        $this->city = $city;
        $this->latitude = $lat;
        $this->longitude = $lng;
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

    function getLatitude()
    {
        return $this->latitude;
    }

    function getLongitude()
    {
        return $this->longitude;
    }

    function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }


}