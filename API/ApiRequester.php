<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 09/09/2016
 * Time: 13:10
 */

namespace Api;


class ApiRequester
{

    private $Http_Headers;

    public function requeteTousContrats()
    {
        $UrlBuilder = new UrlBuilder(UrlBuilder::$CONTRAT);
        $url = $UrlBuilder->buildUrl();
//        var_dump($url);
        return json_decode($this->envoyerGet($url), true);

    }

    public function requeteToutesStations($contrat)
    {
        $UrlBuilder = new UrlBuilder(UrlBuilder::$STATIONS);
        if ($contrat) {
            $UrlBuilder->setParametresGet(['contract' => $contrat]);
            }
        $url = $UrlBuilder->buildUrl();
//        var_dump($url);
        return json_decode($this->envoyerGet($url), true);
    }

    public function requeteStation($station_number, $contract_name){
        $UrlBuilder = new UrlBuilder(UrlBuilder::$STATIONS);
        $UrlBuilder->setCible($UrlBuilder->getCible(). '/' . $station_number);
        if ($contract_name) {
            $UrlBuilder->setParametresGet(['contract' => $contract_name]);
        }
        $url = $UrlBuilder->buildUrl();
//        var_dump($url);
        return json_decode($this->envoyerGet($url), true);
    }

    public function envoyerGet($url){
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

}