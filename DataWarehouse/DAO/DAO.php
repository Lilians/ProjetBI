<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 10/09/2016
 * Time: 12:12
 */
namespace DW;

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
            $this->BDHandler = new \PDO('mysql:host=localhost;dbname=projetbi_dw;charset=utf8', 'root', '');
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

    public function insertVoisinage($station1, $station2, $distance){
        $requete = "INSERT INTO Neighborhood(station_street_id_1, station_street_id_2, distance) VALUES (:station_number1, :station_number2, :distance)";

        $sql = "SELECT station_street_id FROM stationstreet WHERE station_name=:name";

        $station_street_id_1 = $this->executerSelectFetch($sql, ['name' => $station1->getName()])[0];
        $station_street_id_2 = $this->executerSelectFetch($sql, ['name' => $station2->getName()])[0];

        $parametres = [
            'station_number1' => $station_street_id_1,
            'station_number2' => $station_street_id_2,
            'distance' => $distance
        ];
        $this->executerInsert($requete, $parametres);
    }
}