<?php

namespace Api;

/**
 * Cette classe construit les URLs utilisée pour requêter l'API de météo
 * Class MeteoUrlBuilder
 * @package Api
 */
class MeteoUrlBuilder
{
    private static $BASE_URL = "https://api.darksky.net/forecast/";
    private static $API_KEY = "734fe99a699d4a1ff43bc9feb23e0559";
 
    private $cible;

    /**
     * UrlBuilder constructor.
     */
    public function __construct()
    {
    }

	/**
     * UrlBuilder buildUrl
     * @param $lat, $lng
	 * @return mixed
     */
    public function buildUrl($lat, $lng){
        $url = $this::$BASE_URL;
        $url .= $this::$API_KEY;
        $url .= '/'.$lat.','.$lng;
		
        return $url;
    }
}