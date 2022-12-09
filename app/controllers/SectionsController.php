<?php

class SectionsController extends ControllerBase
{
    public function addSectionAction()
    {
        $this->isApiAction = true;
        $obj = $this->request->getJsonRawBody();
        $token = $obj->token;
        $admin = Admins::findFirst([
           'token = :token:',
           'bind' => [
               'token' => $token
           ]
        ]);
        if (!$admin){
            return[
                '_error' => 'Нет прав для данного действия'
            ];
        }

        $section = new Sections();
        $section->name = 'Новая секция товаров';
        $section->save();
        return [
            '_status' => true,
            'section' => $section->name
        ];
    }

    public function removeSectionAction()
    {
        $this->isApiAction = true;
        $obj = $this->request->getJsonRawBody();
        $token = $obj->token;
        $admin = Admins::findFirst([
            'token = :token:',
            'bind' => [
                'token' => $token
            ]
        ]);
        if (!$admin){
            return[
                '_error' => 'Нет прав для данного действия'
            ];
        }
        $sec_name = $obj->section_name;
        $section = Sections::findFirst([
            'name = :name:',
            'bind' => [
                'name' => $sec_name
            ]
        ]);

        if (!$section){
            return [
                '_error' => 'Нет такой секции товаров -> ' . $sec_name
            ];
        }
        $old_name = $section->name;
        $new_sec_name = $obj->new_section_name;
        $section->name = $new_sec_name;
        $section->save();
        
        return [
            '_status' => true,
            'old_name' => $old_name,
            'new_name' => $section->name
        ];
    }

    public function deleteSectionAction()
    {
        $this->isApiAction = true;
        $obj = $this->request->getJsonRawBody();
        $token = $obj->token;
        $admin = Admins::findFirst([
            'token = :token:',
            'bind' => [
                'token' => $token
            ]
        ]);
        if (!$admin){
            return[
                '_error' => 'Нет прав для данного действия'
            ];
        }
        $sec_name = $obj->section_name;
        $section = Sections::findFirst([
            'name = :name:',
            'bind' => [
                'name' => $sec_name
            ]
        ]);
        if (!$section){
            return [
                '_status' => true
            ];
        }
        $section->delete();
        return [
            '_status' => true
        ];
    }
}