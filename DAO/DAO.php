<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 10/09/2016
 * Time: 12:12
 */

namespace DAO;


use Model\Contrat;
use Model\Station;

class DAO
{

    private $BDHandler;

    /**
     * DAO constructor.
     * @param $BDHandler
     */
    public function __construct()
    {
        try {
            $this->BDHandler = new \PDO('mysql:host=localhost;dbname=projetbi;charset=utf8', 'root', '');
        } catch (\Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }


    public function executerSelect($requete, $parametres)
    {
        $requete = $this->BDHandler->prepare($requete);
        $requete->execute($parametres);

        return $requete->fetch();
    }

    public function executerInsert($requete, $parametres)
    {
        $req = $this->BDHandler->prepare($requete);
        $req->execute($parametres);
    }

    public function insertContrat(Contrat $contrat)
    {
        $requete = "INSERT INTO CONTRAT VALUES (:name, :commercial_name, :country_code)";
        $parametres = [
            'name' => $contrat->getName(),
            'commercial_name' => $contrat->getCommercialName(),
            'country_code' => $contrat->getCountryCode()
        ];
        $this->executerInsert($requete, $parametres);
    }

    public function insertAllContrats($array){
        foreach ($array as $contrat){
            $this->insertContrat($contrat);
        }
    }

    public function updateContrat(Contrat $contrat)
    {
        $requete = "UPDATE CONTRAT SET commercial_name=:commercial_name, country_code=:country_code WHERE contrat_name=:name";
        $parametres = [
            'name' => $contrat->getName(),
            'commercial_name' => $contrat->getCommercialName(),
            'country_code' => $contrat->getCountryCode()
        ];
        $this->executerInsert($requete, $parametres);
    }

    public function insertStation(Station $station){
        $requete = "INSERT INTO STATION VALUES (:station_number, :contrat_name, :station_name, :address, :banking, :bonus, :bike_stands)";
        $parametres = array(
            'station_number' => $station->getNumber(),
            'contrat_name' => $station->getContractName(),
            'station_name' => $station->getName(),
            'address' => $station->getAddress(),
            'banking' => $station->getBanking(),
            'bonus' => $station->getBonus(),
            'bike_stands' => $station->getBikeStands()
        );
        $this->executerInsert($requete, $parametres);
    }

    public function insertAllStations($array){
        foreach($array as $station){
            $this->insertStation($station);
        }
    }

    public function updateStation(Station $station){
        $requete = "UPDATE STATION SET contrat_name= :contrat_name, station_name =:station_name, address =:address, banking =:banking, bonus=:bonus, bike_stands=:bike_stands WHERE station_number=:station_number";
        $parametres = array(
            'station_number' => $station->getNumber(),
            'contrat_name' => $station->getContractName(),
            'station_name' => $station->getName(),
            'address' => $station->getAddress(),
            'banking' => $station->getBanking(),
            'bonus' => $station->getBonus(),
            'bike_stands' => $station->getBikeStands()
        );
        $this->executerInsert($requete, $parametres);
    }


}