<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 09/09/2016
 * Time: 13:10
 */

namespace Api;
include_once 'MeteoUrlBuilder.php';
include_once 'JCDecauxUrlBuilder.php';

/**
 * Cette classe requête les différentes sources de données et renvoie le résultat sous forme de tableaux associatifs
 * Class ApiRequester
 * @package Api
 */
class ApiRequester
{
    /**
     * Tableau d'en-têtes HTTP (pas encore utilisé)
     * @var
     */
    private $Http_Headers;

    /**
     * Récupère la liste des contrats auprès de JCDecaux
     * @return mixed
     */
    public function requeteTousContrats()
    {
        $UrlBuilder = new JCDecauxUrlBuilder(JCDecauxUrlBuilder::$CONTRAT);
        $url = $UrlBuilder->buildUrl();
//        var_dump($url);
        return json_decode($this->envoyerGet($url), true);

    }

    /**
     * Récupère l'ensemble des stations associées à un contrat JCDecaux
     * @param $contrat
     * @return mixed
     */
    public function requeteToutesStations($contrat)
    {
        $UrlBuilder = new JCDecauxUrlBuilder(JCDecauxUrlBuilder::$STATIONS);
        if ($contrat) {
            $UrlBuilder->setParametresGet(['contract' => $contrat]);
        }
        $url = $UrlBuilder->buildUrl();
//        var_dump($url);
        return json_decode($this->envoyerGet($url), true);
    }

    /**
     * Requete les informations complémentaires à une station JCDecaux (arrondissement)
     * @param $stations
     * @return mixed
     */
    public function requeteComplementStations($stations)
    {
//        $str = file_get_contents('./Db/pvo_patrimoine_voirie.pvostationvelov_all.json-json.txt', FILE_USE_INCLUDE_PATH);
        $myfile = fopen("./Db/DATA.json", "r") or die("Unable to open file!");
        $jsonData =  fread($myfile,filesize("./Db/DATA.json"));
        fclose($myfile);

        $Data = json_decode($jsonData, true)['values'];

        foreach ($stations as $key => $station) {
            foreach ($Data as $item) {
                if ($station['number'] == $item['idstation']) {

                    $tab = explode(' ', $item['commune']);
                    $station['city'] = $tab[0];
                    if(sizeof($tab) == 1){
                        $station['arrondissement'] = $tab[0];
                    } else {
                        $station['arrondissement']=  $tab[1].' '.$tab[2];
                    }
                    $stations[$key]=  $station;
                }
            }
        }

        return $stations;
    }

    /**
     * Récupère les informations relatives à une station JCDecaux
     * @param $station_number
     * @param $contract_name
     * @return mixed
     */
    public function requeteStation($station_number, $contract_name)
    {
        $UrlBuilder = new JCDecauxUrlBuilder(JCDecauxUrlBuilder::$STATIONS);
        $UrlBuilder->setCible($UrlBuilder->getCible() . '/' . $station_number);
        if ($contract_name) {
            $UrlBuilder->setParametresGet(['contract' => $contract_name]);
        }
        $url = $UrlBuilder->buildUrl();
//        var_dump($url);
        return json_decode($this->envoyerGet($url), true);
    }

    /**
     * Envoie une requête GET à l'URL spécifiée et retourne le résultat
     * @param $url
     * @return mixed|null
     */
    public function envoyerGet($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        $verbose = fopen('../results.txt', 'w+');
        curl_setopt($ch, CURLOPT_STDERR, $verbose);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURL_HTTP_VERSION_1_1, true);

        $result = curl_exec($ch);
        if ($result === FALSE) {
            printf("cUrl error (#%d): %s<br>\n", curl_errno($ch),
                htmlspecialchars(curl_error($ch)));
            return NULL;
        } else return $result;
    }

    /**
     * @return mixed
     */
    public function getHttpHeaders()
    {
        return $this->Http_Headers;
    }

    /**
     * @param mixed $Http_Headers
     */
    public function setHttpHeaders($Http_Headers)
    {
        $this->Http_Headers = $Http_Headers;
    }

    /**
     * Récupère les données météorologiques selon la latitude et la longitude passée en paramètre
     * @param $lat, $lng
     * @return mixed
     */
    public function requeteMeteo($lat, $lng)
    {
        $UrlBuilder = new MeteoUrlBuilder();
        $url = $UrlBuilder->buildUrl($lat, $lng);
//        var_dump($url);
        return json_decode($this->envoyerGet($url), true);
    }

}
