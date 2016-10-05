<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 10/09/2016
 * Time: 12:12
 */

namespace DAO;

include_once './Model/Arrondissement.php';
include_once './Model/City.php';
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
    public static $CITIES = [];
    public static $ARRONDISSEMENTS = [];
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


    public function executerSelectFetch($requete, $parametres)
    {
        $requete = $this->BDHandler->prepare($requete);
        $requete->execute($parametres);

        return $requete->fetch();
    }
    
     public function executerSelectFetchAll($requete, $parametres)
    {
        $requete = $this->BDHandler->prepare($requete);
        $requete->execute($parametres);

        return $requete->fetchAll();
    }

    public function executerInsert($requete, $parametres)
    {
        $req = $this->BDHandler->prepare($requete);
        $req->execute($parametres);
        $a = $req->errorInfo()[1];/// DEBUG
        if ($a != NULL) {
            var_dump("/////////////////////////////////////////");
            var_dump($req->errorInfo());
            var_dump($requete);
            var_dump($parametres);
            var_dump("/////////////////////////////////////////");
        }
    }
    
    public function insertAllContrats($array)
    {
        foreach ($array as $contrat) {
            $this->insertContrat($contrat);
        }
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
        if($contrat->getName() == "Lyon") {
            $Venissieux = new City("VENISSIEUX");
            $Venissieux->setContractName("Lyon");
            $this->insertCity($Venissieux, $contrat);
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
    
    public function insertAllStations($array)
    {
        foreach ($array as $station) {
            $this->insertStation($station);
        }
    }

    public function insertStation(Station $station)
    {
        if ($cities = $this->requeteCity($station->getCity())) {

            if (array_count_values($cities) == 0) {
                $this->insertCity($station->getCity(), $station->getContractName());
            }
        }
        
        if (!$station->getArrondissement()->getId()) {
            $this->insertArrondissement($station->getArrondissement());
        }

        $arr = $this->executerSelectFetch('SELECT * FROM arrondissement WHERE arrondissement_name= :arrondissement_name', array(
            'arrondissement_name' => $station->getArrondissement()->getName()
        ));

        $requete = "INSERT INTO STATION (station_number, city_name, arrondissement_id, contrat_name, station_name, address, banking, bonus, bike_stands, latitude, longitude) VALUES (:station_number, :city_name, :arrondissement_id, :contrat_name, :station_name, :address, :banking, :bonus, :bike_stands, :latitude, :longitude)";
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
            'latitude' => $station->getPosition()->getLat(),
            'longitude' => $station->getPosition()->getLng()
        );
        $this->executerInsert($requete, $parametres);

        foreach ($station->getSnapshots() as $snapshot){
            $this->insertStationSnapshot($snapshot);
        }
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
    
    public function updateStation(Station $station)
    {
        $requete = "UPDATE STATION SET contrat_name= :contrat_name, station_name =:station_name, address =:address, banking =:banking, bonus=:bonus, bike_stands=:bike_stands, latitude=:latitude, longitude=:longitude WHERE station_number=:station_number";
        $parametres = array(
            'station_number' => $station->getNumber(),
            'contrat_name' => $station->getContractName(),
            'station_name' => $station->getName(),
            'address' => $station->getAddress(),
            'banking' => $station->getBanking(),
            'bonus' => $station->getBonus(),
            'bike_stands' => $station->getBikeStands(),
            'latitude' => $station->getPosition()->getLat(),
            'longitude' => $station->getPosition()->getLng()
        );
        $this->executerInsert($requete, $parametres);
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
    
    public function requeteCity(City $city)
    {
        $requete = "SELECT * FROM city WHERE city_name = :city_name";
        return $this->executerSelectFetch($requete, array('city_name' => $city->getName()));
    }
    
    public function getCity($name)
    {
        $requete = "SELECT * FROM ciry WHERE city_name= :name";
        $result = $this->executerSelectFetch($requete, array('name' => $name));
        $city = new City($result['city_name'], $result['contract_name']);
        return $city;
    }

    public function insertCity(City $city, $c)
    {
        if(!array_key_exists($city->getName(), DAO::$CITIES)) {
            $requete = "INSERT INTO city (city_name, contrat_name) VALUE (:city_name, :contrat_name)";
            $parametres = array(
                'city_name' => $city->getName(),
                'contrat_name' => $c instanceof Contrat ? $c->getName() : $c

            );
            $this->executerInsert($requete, $parametres);
            DAO::$CITIES[$city->getName()] = 1;
        }

    }
    
     public function getArrondissement($id)
    {
        $requete = "SELECT * FROM arrondissement WHERE arrondissement_id= :id";
        $result = $this->executerSelectFetch($requete, array('id' => $id));
        $arr = new Arrondissement($result['arrondissement_name'], $this->getCity($result['city_name']));
        $arr->setId($result['arrondissement_id']);
        $arr->setLatitude((float) $result['latitude']);
        $arr->setLongitude((float) $result['longitude']);
        return $arr;
    }
    
    public function getArrondissements()
    {
        $requete = "SELECT * FROM arrondissement ";
        $result = $this->executerSelectFetchAll($requete, null);
        $arrs = [];
        foreach($result as $ar)
        {
            $arr = new \Model\Arrondissement($ar['arrondissement_name'], $this->getCity($ar['city_name']));
            $arr->setId($ar['arrondissement_id']);
            $arr->setLatitude((float) $ar['latitude']);
            $arr->setLongitude((float) $ar['longitude']);
            $arrs[] = $arr;
        } 
        return $arrs;
    }

    public function insertArrondissement(Arrondissement $arrondissement)
    {
        if(!array_key_exists($arrondissement->getName(), DAO::$ARRONDISSEMENTS)) {
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
            DAO::$ARRONDISSEMENTS[$arrondissement->getName()] = 1;
        }
    }
    
    public function getLastMeteoArrondissementSnapshot()
    {
        $requete = "SELECT * FROM meteo_arrondissement_snapshot GROUP BY arrondissement_id ORDER BY last_update DESC";
        $array = $this->executerSelectFetchAll($requete, null);
        if($array)
        {
            $masReturn = [];
            foreach($array as $masa)
            {
               $mas = new \Model\MeteoArrondissementSnapshot();
               $mas->setId($masa['meteo_arrondissement_snapshot_id']);
               $mas->setArrondissement($this->getArrondissement($masa['arrondissement_id']));
               $mas->setLastUpdate($masa['last_update']);
               $mas->setLastTime($masa['last_time']);
               $mas->setSummary($masa['summary']);
               $mas->setTemperature($masa['temperature']);
               $mas->setApparentEmperature($masa['summary']);
               $mas->setCloudCover($masa['cloud_cover']);
               $mas->setHumidity($masa['humidity']);
               $mas->setPrecipIntensity($masa['precip_intensity']);
               $mas->setPrecipProbability($masa['precip_probability']);
               $mas->setWindBearing($masa['wind_bearing']);
               $mas->setWindSpeed($masa['wind_speed']);
               $masReturn[] = $mas;
            }
            return $masReturn;
        }
        return null;
        
    }
    
    public function insertMeteoArrondissementSnapshot(\Model\MeteoArrondissementSnapshot $snapshot){
        $requete = "INSERT INTO meteo_arrondissement_snapshot (arrondissement_id, last_time, last_update, summary, temperature, apparent_temperature, humidity, cloud_cover, wind_bearing, wind_speed, precip_intensity, precip_probability) "
                . "VALUES (:arrondissement_id, :last_time, :last_update, :summary, :temperature, :apparent_temperature, :humidity, :cloud_cover, :wind_bearing, :wind_speed, :precip_intensity, :precip_probability)";
        $parametres = [
            'arrondissement_id' => $snapshot->getArrondissement()->getId(),
            'last_time' => $snapshot->getLastTime(),
            'last_update' => $snapshot->getLastUpdate(),
            'summary' => $snapshot->getSummary(),
            'temperature' => $snapshot->getTemperature(),
            'apparent_temperature' => $snapshot->getApparentTemperature(),
            'humidity' => $snapshot->getHumidity(),
            'cloud_cover' => $snapshot->getCloudCover(),
            'wind_bearing' => $snapshot->getWindBearing(),
            'wind_speed' => $snapshot->getWindSpeed(),
            'precip_intensity' => $snapshot->getPrecipIntensity(),
            'precip_probability' => $snapshot->getPrecipProbability()
        ];
        $this->executerInsert($requete, $parametres);
    }
}