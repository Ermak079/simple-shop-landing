<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public $isApiAction = false;

    public function afterExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher)
    {
        if ($this->isApiAction) {
            $this->view->disable();
            $result = $dispatcher->getReturnedValue();
            $this->response->setJsonContent($result);
            $this->response->send();
        }
    }
}
