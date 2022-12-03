<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {

    }

    public function getAllAction()
    {
       $this->isApiAction = true;
       $set = Settings::find();
       $sections = Sections::find();
       $result = [];
       foreach ($sections as $section){
           $result[] = $section->toApi();
       }
       return [
           'settings' => $set,
           'sections' => $result
       ];
    }

}

