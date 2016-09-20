<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 09/09/2016
 * Time: 12:44
 */

namespace Model;
include_once 'City.php';

class Contrat
{
    private $name;
    private $commercial_name;
    private $country_code;
    private $cities;

    public static function createContratFromArray($array)
    {
        $C = new Contrat();
        $C->setName($array['name']);
        $C->setCommercialName($array['commercial_name']);
        $C->setCountryCode($array['country_code']);

        $C->cities = [];
        foreach ($array['cities'] as $city) {
            $C->cities[] = new City($city);
        }

        return $C;
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
    public function getCommercialName()
    {
        return $this->commercial_name;
    }

    /**
     * @param mixed $commercial_name
     */
    public function setCommercialName($commercial_name)
    {
        $this->commercial_name = $commercial_name;
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->country_code;
    }

    /**
     * @param mixed $country_code
     */
    public function setCountryCode($country_code)
    {
        $this->country_code = $country_code;
    }

    /**
     * @return mixed
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * @param mixed $cities
     */
    public function setCities($cities)
    {
        $this->cities = $cities;
    }

}