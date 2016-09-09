<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 09/09/2016
 * Time: 12:54
 */

include_once 'Model/Contrat.php';
include_once 'Model/Position.php';
include_once 'Model/Station.php';

include_once 'API/ApiRequester.php';
include_once 'API/UrlBuilder.php';

include 'DAO/Service.php';


$a = new Api\ApiRequester();

$s = new \DAO\Service();

//$contrats = $s->peuplerContrats($a->requeteTousContrats());

//$stations = $s->peuplerStations($a->requeteToutesStations('Lyon'));
$stations = $s->peuplerStation($a->requeteStation(2010, 'Lyon'));
var_dump($stations);

