<?php
/**
 * Created by PhpStorm.
 * User: Luke Hardiman
 * Date: 19/06/2015
 * Time: 3:30 PM
 */



use Phalcon\Mvc\Model\Criteria;


class ApiController extends JSONController
{

    /**
     * Index action
     */
    public function IndexAction() {
        //$oh = $this->request->get("api_key");

        $this->response->setJsonContent(array('status' => 'ERROR', 'messages' => "Incorrect CALL"));
        return $this->response;
    }


    public function show404Action()
    {
        $this->response->setStatusCode(404, 'Not Found');
        $this->response->setJsonContent(array('status' => 'ERROR', 'messages' => "not found"));
        //$this->view->pick('error/show404');
        return $this->response;
    }




}


