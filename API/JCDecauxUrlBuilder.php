<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 09/09/2016
 * Time: 13:36
 */

namespace Api;


class JCDecauxUrlBuilder
{
    private static $BASE_URL = "https://api.jcdecaux.com/vls/v1/";
    private static $API_KEY = "12f6bfe6467f8f8babf0784e7e867ddc9520276c";
    public static $CONTRAT = "contracts";
    public static $STATIONS = "stations";


    private $parametres_get;
    private $cible;

    /**
     * UrlBuilder constructor.
     * @param $cible
     */
    public function __construct($cible)
    {
        $this->cible = $cible;
    }

    public function buildUrl(){
        $url = $this::$BASE_URL;
        $url .= $this->cible . '?';

        if(!empty($this->parametres_get)){
            foreach ($this->parametres_get as $parameter => $value){
                $url .= $parameter.'='. $value . '&';
            }
        }
        $url .= 'apiKey='.$this::$API_KEY;
        return $url;
    }

    /**
     * @return mixed
     */
    public function getParametresGet()
    {
        return $this->parametres_get;
    }

    /**
     * @param mixed $parametres_get
     */
    public function setParametresGet($parametres_get)
    {
        $this->parametres_get = $parametres_get;
    }

    /**
     * @return mixed
     */
    public function getCible()
    {
        return $this->cible;
    }

    /**
     * @param mixed $cible
     */
    public function setCible($cible)
    {
        $this->cible = $cible;
    }


}