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
            'bind' => $ad_name
        ]);

        if (!$admin) {
            return [
                '_error' => 'Введены неверные данные'
            ];
        }

        if ($admin->password != sha1($ad_password)){
            return [
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

}

