<?php
/**
 * Renseigne les données de voisinage dans l'entrepôt de données.
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
include_once 'DataWarehouse/DAO/DAO.php';

$a = new Api\ApiRequester();

$s = new \DAO\Service();

$dao = new \DW\DAO();

$stations_array = $a->requeteComplementStations($a->requeteToutesStations('Lyon'));

$stations_array = $s->peuplerStations($stations_array);


foreach ($stations_array as $sta1) {
    foreach ($stations_array as $sta2) {
        if ($sta1->getNumber() != $sta2->getNumber()) {
            $lat1 = $sta1->getPosition()->getLat();
            $lng1 = $sta1->getPosition()->getLng();
            $lat2 = $sta2->getPosition()->getLat();
            $lng2 = $sta2->getPosition()->getLng();

            if (isset($lat1) && isset($lng1) && isset($lat2) && isset($lng2)) {
                $latFrom = deg2rad($lat1);
                $lonFrom = deg2rad($lng1);
                $latTo = deg2rad($lat2);
                $lonTo = deg2rad($lng2);

                $latDelta = $latTo - $latFrom;
                $lonDelta = $lonTo - $lonFrom;

                $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
                $distance = $angle * 6371000;

                if ($distance < 500) {
                    $dao->insertVoisinage($sta1, $sta2, $distance);
                }

            } else {
                die("Error");
            }
        }
    }
}
