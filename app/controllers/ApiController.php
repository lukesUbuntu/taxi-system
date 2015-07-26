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
        $this->response("Invalid API call",false);
    }

    /**
     * @call api/getRegistration
     * @param  ?reg | Vehicle Registration
     * @type GET request (will be moved to POST after testing)
     * @return JSON data of taxi registration
     */
    public function getRegistrationAction(){

        if (!$this->request->isGet())
            $this->response("incorrect request type",false);

        //get reg if not null
        $taxi_reg = $this->request->get("reg",null,false);

        if (!$taxi_reg)
            $this->response("No reg passed",false);

        //get taxi record
        $taxi = Registrations::query()
            ->where("REG = :REG:")
            ->bind(array("REG" => $taxi_reg))
            ->execute();

        //process if we have result
        if (count($taxi) > 0)
            $this->response($taxi[0]->Details());
        else
            $this->response("no results",false);
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
     * @param $data response to send back as JSON with Callback
     * @param bool|true $success
     * @param int $status_code of response default 200
     * @param string $status_message of response default OK
     */
    public function response($data, $success = true, $status_code = 200 , $status_message = "OK"){
        //disable view
        $this->view->disable();
        //new response
        $response = new \Phalcon\Http\Response();
        $response->setStatusCode($status_code, $status_message);
        $response->setContentType('application/json', 'utf-8');
        //encode call
        $json = json_encode(array ('success' => $success, 'data' => $data));
        //set response to send back check for callback
        $response->setContent(isset($_GET['callback'])
            ? "{$_GET['callback']}($json)"
            : $json);
        $response->send();
        exit; //kill from other processing


    }

}


