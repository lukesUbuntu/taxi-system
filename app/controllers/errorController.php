<?php
/**
 * Created by PhpStorm.
 * User: Luke Hardiman
 * Date: 19/06/2015
 * Time: 4:53 PM
 */

/**
 * ErrorController
 */
class ErrorController extends \Phalcon\Mvc\Controller
{
    public function show404Action()
    {
        $this->response->setStatusCode(404, 'Not Found');
        $this->view->pick('404/404');
    }

    public function notFoundAction()
    {
       // echo "here";exit;
        // The response is already populated with a 404 Not Found header.
        //$this->response->setStatusCode(404, 'Not Found');
        return $this->view->pick('404/404');
    }

    public function uncaughtExceptionAction()
    {
       // echo "here";exit;
        // You need to specify the response header, as it's not automatically set here.
        $this->response->setStatusCode(500, 'Internal Server Error');
    }
}