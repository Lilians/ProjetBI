<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 16/09/2016
 * Time: 10:30
 */


  include_once 'Model/StationSnapshot.php';
  include_once 'Model/MeteoArrondissementSnapshot.php';

  include_once 'API/ApiRequester.php';
  include_once 'DAO/Service.php';
  include_once 'DAO/DAO.php';


  $a = new Api\ApiRequester();

  $s = new \DAO\Service();

  $dao = new \DAO\DAO();
  
  
  //ajout snapshot stations
  $stations_array = $a->requeteComplementStations($a->requeteToutesStations('Lyon'));
  
  foreach ($stations_array as $array){
      $dao->insertStationSnapshot(Model\StationSnapshot::createStationSnapshotFromArray($array));
  }
  
  //ajout snapshot meteo arrondissement
  $meteoArrondissementSnapshots = $dao->getLastMeteoArrondissementSnapshot();
  if($meteoArrondissementSnapshots) //mise a jour 
  {
        foreach ($meteoArrondissementSnapshots as $mas)
        {
            $datetime1 = date_create($mas->getLastUpdate());
            $datetime2 = date_create($mas->getLastTime());
            $datetime3 = new DateTime();
            $interval1 = $datetime3->diff($datetime1);
            $interval2 = $datetime3->diff($datetime2);
            if($interval1->format('%i')> 30 || $interval2->format('%i') > 180) // si la dernière mise a jour date de plus d'une heure, ou que les données datent de plus de 3 heures
            {
                $array_meto = $a->requeteMeteo($mas->getArrondissement()->getLatitude(), $mas->getArrondissement()->getLongitude());
                $dao->insertMeteoArrondissementSnapshot(Model\MeteoArrondissementSnapshot::createMeteoArrondissementSnapshotFromArray($mas->getArrondissement(), $array_meto));
            }
        }
  }
  else //ajout initial 
  {
      $arrondissements = $dao->getArrondissements();
      foreach($arrondissements as $arr)
      {
        $array_meto = $a->requeteMeteo($arr->getLatitude(), $arr->getLongitude());
        $dao->insertMeteoArrondissementSnapshot(Model\MeteoArrondissementSnapshot::createMeteoArrondissementSnapshotFromArray($arr, $array_meto));
      }
  }
  
 
 
    

