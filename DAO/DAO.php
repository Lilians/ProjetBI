<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 10/09/2016
 * Time: 12:12
 */

namespace DAO;


use Model\Arrondissement;
use Model\City;
use Model\Contrat;
use Model\Station;
use Model\StationSnapshot;

/**
 * Effectue la liaison avec la base de donneés
 * Class DAO
 * @package DAO
 */
class DAO
{

    private $BDHandler;

    /**
     * DAO constructor.
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
        if ($req->errorInfo()[1] != NULL) {
            var_dump($req->errorInfo());
        }
    }

    public function insertStationSnapshot(StationSnapshot $snapshot){
        $requete = "INSERT INTO station_snapshot(station_number, available_bike_stands, available_bikes, last_update) VALUES (:station_number, :available_bike_stands, :available_bikes, :last_update)";
        $parametres = [
            'station_number' => $snapshot->getStationNumber(),
            'available_bike_stands' => $snapshot->getAvailableBikeStands(),
            'available_bikes' => $snapshot->getAvailableBikes(),
            'last_update' => $snapshot->getLastUpdate()
        ];
        $this->executerInsert($requete, $parametres);
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
        foreach ($contrat->getCities() as $city) {
            $this->insertCity($city, $contrat);
        }
    }

    public function insertAllContrats($array)
    {
        foreach ($array as $contrat) {
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

    public function insertStation(Station $station)
    {
        if ($cities = $this->requeteCity($station->getCity())) {

            if (array_count_values($cities) == 0) {
                $this->insertCity($station->getCity(), $station->getContractName());
            }
        }
//        $this->insertCity($station->getCity());
        if (!$station->getArrondissement()->getId()) {
            $this->insertArrondissement($station->getArrondissement());
        }

        $arr = $this->executerSelect('SELECT * FROM arrondissement WHERE arrondissement_name= :arrondissement_name', array(
            'arrondissement_name' => $station->getArrondissement()->getName()
        ));

        $requete = "INSERT INTO STATION (station_number, city_name, arrondissement_id, contrat_name, station_name, address, banking, bonus, bike_stands) VALUES (:station_number, :city_name, :arrondissement_id, :contrat_name, :station_name, :address, :banking, :bonus, :bike_stands)";
        $parametres = array(
            'station_number' => $station->getNumber(),
            'city_name' => $station->getCity()->getName(),
            'arrondissement_id' => $arr['arrondissement_id'],
            'contrat_name' => $station->getContractName(),
            'station_name' => $station->getName(),
            'address' => $station->getAddress(),
            'banking' => $station->getBanking(),
            'bonus' => $station->getBonus(),
            'bike_stands' => $station->getBikeStands(),
        );
        $this->executerInsert($requete, $parametres);

        foreach ($station->getSnapshots() as $snapshot){
            $this->insertStationSnapshot($snapshot);
        }
    }

    public function requeteCity(City $city)
    {
        $requete = "SELECT * FROM city WHERE city_name = :city_name";
        return $this->executerSelect($requete, array('city_name' => $city->getName()));
    }

    public function insertAllStations($array)
    {
        foreach ($array as $station) {
            $this->insertStation($station);
        }
    }

    public function updateStation(Station $station)
    {
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

    public function insertCity(City $city, $c)
    {
        $requete = "INSERT INTO city (city_name, contrat_name) VALUE (:city_name, :contrat_name)";
        $parametres = array(
            'city_name' => $city->getName(),
            'contrat_name' => $c instanceof Contrat ? $c->getName() : $c

        );

        $this->executerInsert($requete, $parametres);
    }

    public function insertArrondissement(Arrondissement $arrondissement)
    {
        if ($arrondissement->getId() != null) {
            $requete = "INSERT INTO arrondissement VALUES (:arrondissement_id, :city_name, :arrondissement_name)";
            $parametres = array(
                'arrondissement_id' => $arrondissement->getId(),
                'city_name' => $arrondissement->getCity()->getName(),
                'arrondissement_name' => $arrondissement->getName()
            );
        } else {
            $requete = "INSERT INTO arrondissement (arrondissement_name, city_name) VALUE (:arrondissement_name, :city_name)";
            $parametres = array(
                'arrondissement_name' => $arrondissement->getName(),
                'city_name' => $arrondissement->getCity()->getName()
            );
        }


        $this->executerInsert($requete, $parametres);
    }

    public function setStationArrondissement(Station $station, Arrondissement $arrondissement)
    {
        $requete = "UPDATE STATION SET arrondissement_id = :arrondissement_id WHERE station_number= :station_number";
        $parametres = array(
            'station_number' => $station->getNumber(),
            'arrondissement_id' => $arrondissement->getId()
        );
        $this->executerInsert($requete, $parametres);
    }

    public function setStationCity(Station $station, City $city)
    {
        $requete = "UPDATE STATION SET city_name = :city_name WHERE station_number= :station_number";
        $parametres = array(
            'station_number' => $station->getNumber(),
            'city_id' => $city->getName()
        );
        $this->executerInsert($requete, $parametres);
    }
}