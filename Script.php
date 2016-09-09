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

$a = new Api\ApiRequester();


var_dump($a->requeteTousContrats());
var_dump($a->requeteToutesStations('Lyon'));
var_dump($a->requeteStation(2010, 'Lyon'));