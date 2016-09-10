<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 10/09/2016
 * Time: 13:21
 */

namespace Model;


use DAO\DAO;

class City
{
    private $name;
    private $contract_name;

    /**
     * City constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = strtoupper($name);
        $dao = new DAO();
        $res = $dao->executerSelect('SELECT * FROM city WHERE city_name=:city_name', ['city_name' => $this->name]);
        if(!empty($res)){
            $this->contract_name = $res['contrat_name'];
        }
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
        $this->name = strtoupper($name);
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


}