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
     * Returns a formatted array of the taxi data
     * @return array
     */
    public function Details(){
        $record = array(
            'id'        =>  $this->record_id,
            'decal'     =>  $this->Decal,
            'service'   =>  $this->ServiceType,
            'fleet'     =>  $this->Fleet,
            'ato'       =>  $this->ATO,
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


}
