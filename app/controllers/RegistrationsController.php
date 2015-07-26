<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class RegistrationsController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for registrations
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Registrations", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "record_id";

        $registrations = Registrations::find($parameters);
        if (count($registrations) == 0) {
            $this->flash->notice("The search did not find any registrations");

            return $this->dispatcher->forward(array(
                "controller" => "registrations",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $registrations,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a registration
     *
     * @param string $record_id
     */
    public function editAction($record_id)
    {

        if (!$this->request->isPost()) {

            $registration = Registrations::findFirstByrecord_id($record_id);
            if (!$registration) {
                $this->flash->error("registration was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "registrations",
                    "action" => "index"
                ));
            }

            $this->view->record_id = $registration->record_id;

            $this->tag->setDefault("record_id", $registration->record_id);
            $this->tag->setDefault("REG", $registration->REG);
            $this->tag->setDefault("ATO", $registration->ATO);
            $this->tag->setDefault("Decal", $registration->Decal);
            $this->tag->setDefault("Year", $registration->Year);
            $this->tag->setDefault("Make", $registration->Make);
            $this->tag->setDefault("Model", $registration->Model);
            $this->tag->setDefault("Fleet", $registration->Fleet);
            $this->tag->setDefault("ServiceType", $registration->ServiceType);
            
        }
    }

    /**
     * Creates a new registration
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "registrations",
                "action" => "index"
            ));
        }

        $registration = new Registrations();

        $registration->REG = $this->request->getPost("REG");
        $registration->ATO = $this->request->getPost("ATO");
        $registration->Decal = $this->request->getPost("Decal");
        $registration->Year = $this->request->getPost("Year");
        $registration->Make = $this->request->getPost("Make");
        $registration->Model = $this->request->getPost("Model");
        $registration->Fleet = $this->request->getPost("Fleet");
        $registration->ServiceType = $this->request->getPost("ServiceType");
        

        if (!$registration->save()) {
            foreach ($registration->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "registrations",
                "action" => "new"
            ));
        }

        $this->flash->success("registration was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "registrations",
            "action" => "index"
        ));

    }

    /**
     * Saves a registration edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "registrations",
                "action" => "index"
            ));
        }

        $record_id = $this->request->getPost("record_id");

        $registration = Registrations::findFirstByrecord_id($record_id);
        if (!$registration) {
            $this->flash->error("registration does not exist " . $record_id);

            return $this->dispatcher->forward(array(
                "controller" => "registrations",
                "action" => "index"
            ));
        }

        $registration->REG = $this->request->getPost("REG");
        $registration->ATO = $this->request->getPost("ATO");
        $registration->Decal = $this->request->getPost("Decal");
        $registration->Year = $this->request->getPost("Year");
        $registration->Make = $this->request->getPost("Make");
        $registration->Model = $this->request->getPost("Model");
        $registration->Fleet = $this->request->getPost("Fleet");
        $registration->ServiceType = $this->request->getPost("ServiceType");
        

        if (!$registration->save()) {

            foreach ($registration->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "registrations",
                "action" => "edit",
                "params" => array($registration->record_id)
            ));
        }

        $this->flash->success("registration was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "registrations",
            "action" => "index"
        ));

    }

    /**
     * Deletes a registration
     *
     * @param string $record_id
     */
    public function deleteAction($record_id)
    {

        $registration = Registrations::findFirstByrecord_id($record_id);
        if (!$registration) {
            $this->flash->error("registration was not found");

            return $this->dispatcher->forward(array(
                "controller" => "registrations",
                "action" => "index"
            ));
        }

        if (!$registration->delete()) {

            foreach ($registration->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "registrations",
                "action" => "search"
            ));
        }

        $this->flash->success("registration was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "registrations",
            "action" => "index"
        ));
    }





}
