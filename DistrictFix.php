<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 21/10/2016
 * Time: 16:31
 */

include_once 'Model/Contrat.php';
include_once 'Model/Position.php';
include_once 'Model/Station.php';
include_once 'Model/Arrondissement.php';

include_once 'DAO/DAO.php';

$myfile = fopen("./Db/DATA.json", "r") or die("Unable to open file!");
$jsonData = fread($myfile, filesize("./Db/DATA.json"));
fclose($myfile);


$Data = json_decode($jsonData, true)['values'];
$arrondissements = [];
$i = 0;

$dao = new \DAO\DAO();
$stations = $dao->getStations();

foreach ($stations as $sta) {
    foreach ($Data as $item) {
        if ($item['idstation'] == $sta->getNumber()) {
            $tab = explode(' ', $item['commune']);
            $city = $tab[0];
            if (sizeof($tab) == 1) {
                $arr = $tab[0];
            } else {
                $arr = $tab[1] . ' ' . $tab[2];
            }
            $a = new \Model\Arrondissement($arr, new \Model\City($city));
            $dao->insertArrondissement($a);
            $sta->setArrondissement($a);
        }
    }
}

$mysql = "UPDATE station SET arrondissement_id = (
SELECT arrondissement_id FROM arrondissement 
WHERE arrondissement.arrondissement_name= :arrondissement_name 
  AND arrondissement.city_name=:city_name
  ) WHERE station_number=:station_number;";

foreach ($stations as $sta) {
    $dao->executerInsert($mysql, [
        'station_number' => $sta->getNumber(),
        'arrondissement_name' => $sta->getArrondissement()->getName(),
        'city_name' => $sta->getArrondissement()->getCity()->getName()
    ]);
}