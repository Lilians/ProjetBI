<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 09/09/2016
 * Time: 21:43
 */


namespace DAO;


use Model\Contrat;
use Model\Station;

class Service
{
    //ToDO : Intégration BDD




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

    public function peuplerVilles($array)
    {

    }

    public function peuplerVille($array)
    {

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