<?php
/**
 * Created by PhpStorm.
 * User: Luke Hardiman
 * Date: 26/06/2015
 * Time: 3:30 PM
 */

use Phalcon\Mvc\Model\Criteria;


class ApiController extends JSONController
{

    /**
     * Index action main call to /api
     */
    public function IndexAction() {
        return $this->response("Invalid API call",false);
    }

    /**
     * @call api/getRegistration
     * @param  ?reg | Vehicle Registration
     * @type GET request (will be moved to POST after testing)
     * @return JSON data of taxi registration
     */
    public function getRegistrationAction(){

        if (!$this->request->isGet()) {

            $this->response("incorrect request type",false);
        }
        //get reg if not null
        $taxi_reg = $this->request->get("reg",null,false);

        if (!$taxi_reg)
            return $this->response("No reg passed",false);

        //get taxi record
        $taxi = Registrations::query()
            ->where("REG = :REG:")
            ->bind(array("REG" => $taxi_reg))
            ->execute();

        //process if we have result
        if (count($taxi) > 0)
            return $this->response($taxi[0]->Details());
        else
            return $this->response("no results",false);
    }

    /**
     * 404 for API (still working on)
     * @return mixed
     */
    public function show404Action()
    {
        $this->response->setStatusCode(404, 'Not Found');
        $this->response->setJsonContent(array('status' => 'ERROR', 'messages' => "not found"));
        //$this->view->pick('error/show404');
        return $this->response;
    }

    /**
     * @param $data response to send back as JSON
     * @param bool|true $status
     * @return JSON
     */
    public function response($data,$status = true){
        //@todo add in JSONP callback
        $this->response->setJsonContent(array('status' => $status, 'data' => $data));
        return $this->response;
    }

}


