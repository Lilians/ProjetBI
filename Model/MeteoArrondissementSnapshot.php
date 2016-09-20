<?php

namespace Model;


class MeteoArrondissementSnapshot
{
    private $id;
    private $arrondissement;
    private $last_time;
    private $last_update;
    
    public function __construct()
    {
    }

    public static function createMeteoArrondissementSnapshotFromArray(Arrondissement $arr, $array)
    {
        $Snap = new MeteoArrondissementSnapshot();
        $Snap->setArrondissement($arr);
        $Snap->setLastTime( date('Y-m-d H:i:s', $array['currently']['time']));
        $Snap->setLastUpdate( date('Y-m-d H:i:s'));
        return $Snap;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
        
    }
    function getArrondissement()
    {
        return $this->arrondissement;
    }

    function setArrondissement($arrondissement)
    {
        $this->arrondissement = $arrondissement;
    }

       
    /**
     * @return mixed
     */
    public function getLastUpdate()
    {
        return $this->last_update;
    }

    /**
     * @param mixed $last_update
     */
    public function setLastUpdate($last_update)
    {
        $this->last_update = $last_update;
    }
    
    function getLastTime()
    {
        return $this->last_time;
    }

    function setLastTime($last_time)
    {
        $this->last_time = $last_time;
    }




}