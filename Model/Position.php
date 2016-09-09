<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 09/09/2016
 * Time: 12:43
 */

namespace Model;


class Position
{

    public static $KEYS = ['lat', 'lng'];
    private $lat;
    private $lng;

    public static function createPositionFromArray($array)
    {
        $P = new Position();
        $P->setLat($array['lat']);
        $P->setLng($array['lng']);
        return $P;
    }
        /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param mixed $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }


}