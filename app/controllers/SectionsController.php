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
                '_status' => false,
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

    public function editSectionAction()
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
                '_status' => false,
                '_error' => 'Нет прав для данного действия'
            ];
        }
        $section_id = $obj->section_id;
        $section = Sections::findFirst([
            'id = :id:',
            'bind' => [
                'id' => $section_id
            ]
        ]);

        if (!$section){
            return [
                '_status' => false,
                '_error' => 'Нет такой секции товаров'
            ];
        }
        $new_sec_name = $obj->new_section_name ?? false;
        if ($new_sec_name)
        {
            $section->name = $new_sec_name;
            $section->save();
            return [
                '_status' => true,
                'section' => $section
            ];
        } else {
            return [
                '_status' => false,
                '_error' => 'Нет данных для изменения секции'
            ];
        }
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
                '_status' => false,
                '_error' => 'Нет прав для данного действия'
            ];
        }
        $section_id = $obj->section_id;
        $section = Sections::findFirst([
            'id = :id:',
            'bind' => [
                'id' => $section_id
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

    public function uploadPictureForSectionAction()
    {
        $this->isApiAction = true;
        $obj = $this->request->getPost();
        $token = $obj['token'];
        $admin = Admins::findFirst([
            'token = :token:',
            'bind' => [
                'token' => $token
            ]
        ]);
        if (!$admin){
            return[
                '_status' => false,
                '_error' => 'Нет прав для данного действия'
            ];
        }
        $file = $this->request->getUploadedFiles();
        if (empty($file))
        {
            return [
                '_status' => false
            ];
        }
        $file = $file[0];
        $picture = new Pictures();
        $picture->file_name = rand(1, 9999999) . '.' . $file->getExtension();
        $picture->save();
        $file->moveTo('img/' . $picture->file_name);
        $section_id = $this->dispatcher->getParam('sectionId');
        $section = Sections::findFirst('id = ' . $section_id);
        $section->picture_id = $picture->id;
        $section->save();
        return [
            '_status' => true
        ];
    }
}