<?php

class IndexController extends ControllerBase
{

    public function authAction()
    {
        $this->isApiAction = true;
        $obj = $this->request->getJsonRawBody();
        $ad_name = $obj->name;
        $ad_password = $obj->password;
        $admin = Admins::findFirst([
            'name = :name:',
            'bind' => [
                'name' => $ad_name
            ]
        ]);

        if (!$admin) {
            return [
                '_status' => false,
                '_error' => 'Введены неверные данные'
            ];
        }

        if ($admin->password != sha1($ad_password)){
            return [
                '_status' => false,
                '_error' => 'Введены неверные данные'
            ];
        }
        $admin->token = sha1(random_bytes(500));
        $admin->save();
        return [
            '_status' => true,
            'token' => $admin->token
        ];

    }

    public function getAllAction()
    {
        $this->isApiAction = true;
        $set = Settings::find();
        $res = [];
        foreach ($set as $item)
        {
            $res[$item->key] = json_decode($item->value);
        }
        $sections = Sections::find();
        $result = [];
        foreach ($sections as $section){
            $result[] = $section->toApi();
        }
        return [
            'settings' => $res,
            'sections' => $result,
        ];
    }

}

