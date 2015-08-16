<?php

class Registrations extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $record_id;
    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $REG;

    /**
     *
     * @var string
     */
    public $ATO;

    /**
     *
     * @var string
     */
    public $Decal;

    /**
     *
     * @var string
     */
    public $Year;

    /**
     *
     * @var string
     */
    public $Make;

    /**
     *
     * @var string
     */
    public $Model;

    /**
     *
     * @var integer
     */
    public $Fleet;

    /**
     *
     * @var string
     */
    public $ServiceType;

    /**
     *
     * @var integer
     */
    public $banned;

    /**
     * Returns a formatted array of the taxi data
     * @return array
     */
    public function Details(){
        $record = array(
            'id'        =>  $this->record_id,
            'name'      =>  $this->name,
            'decal'     =>  $this->Decal,
            'service'   =>  $this->ServiceType,
            'fleet'     =>  $this->Fleet,
            'ato'       =>  $this->ATO,
            'isbanned'  =>  ((int)$this->banned == 1)? true : false,

            //vehicle details
            'vehicle' => array(
                    'make'  => $this->Make,
                    'model' => $this->Model,
                    'year'  => $this->Year,
                    'reg'  => $this->REG
            )
        );

        return $record;
    }
    /**
     * Saves Details from a taxiObject
     *
     */
    public function UpdateDetails($taxi){
        $this->record_id = $taxi->id;
        $this->name = $taxi->name;
        $this->Decal = $taxi->decal;
        $this->ServiceType = $taxi->service;
        $this->Fleet = $taxi->fleet;
        $this->ATO = $taxi->ato;
        $this->banned = (int)$taxi->isbanned;

        $this->Make = $taxi->vehicle->make;
        $this->Model = $taxi->vehicle->model;
        $this->Year = $taxi->vehicle->year;
        $this->REG = $taxi->vehicle->reg;

    }

}
