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

    /**
     * Construit un objet arrondissement, si l'objet existe déjà en base, utilise celui de la base
     * Arrondissement constructor.
     * @param $name
     */
    public function __construct($name, City $city)
    {
        $this->name = $name;
        $this->city = $city;

        $dao = new DAO();
        $res = $dao->executerSelect('SELECT * FROM arrondissement WHERE arrondissement_name = :arrondissement_name AND city_name=:city_name', [
            'arrondissement_name' => $name,
            'city_name' => $city->getName()
        ]);

        if (!empty($res)) {
            $this->id = $res['arrondissement_id'];
        }
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


}