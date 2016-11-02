<?php
/**
 * Renseigne les données de base du projet :
 *          - Les différents contrats de JCDecaux concernant les vélos en libre service
 *          - Les différentes stations de l'agglomération Lyonnaise ainsi que les données complémentaires qui leur sont associées.
 * User: Vlad
 * Date: 09/09/2016
 * Time: 12:54
 */

include_once 'Model/Contrat.php';
include_once 'Model/Position.php';
include_once 'Model/Station.php';

include_once 'API/ApiRequester.php';
include_once 'API/JCDecauxUrlBuilder.php';

include_once 'DAO/Service.php';
include_once 'DAO/DAO.php';

$a = new Api\ApiRequester();

$s = new \DAO\Service();

$dao = new \DAO\DAO();

$contrats = $s->peuplerContrats($a->requeteTousContrats());
$dao->insertAllContrats($contrats);


$stations_array = $a->requeteComplementStations($a->requeteToutesStations('Lyon'));


$stations = $s->peuplerStations($stations_array);

$arrondissements = [];


$dao->insertAllStations($stations);
