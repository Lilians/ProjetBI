<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 09/09/2016
 * Time: 21:43
 */


namespace DAO;


use Model\Arrondissement;
use Model\City;
use Model\Contrat;
use Model\Station;

/**
 * Effectue les conversions de tableaux associatifs en objets du modèle
 * Class Service
 * @package DAO
 */
class Service
{

    public function peuplerContrats($array)
    {
        $contrats = [];
        foreach ($array as $contrat){
            $contrats[] = $this->peuplerContrat($contrat);
        }
        return $contrats;
    }

    public function peuplerContrat($array)
    {
        $contrat = Contrat::createContratFromArray($array);
        return $contrat;
    }

    public function peuplerStations($array)
    {
        $stations = [];
        foreach ($array as $station){
            $stations[] = $this->peuplerStation($station);
        }
        return $stations;
    }

    public function peuplerStation($array)
    {
        $station = Station::createStationFromArray($array);
        return $station;
    }

}