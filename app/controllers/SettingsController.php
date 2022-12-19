<?php

class SettingsController extends ControllerBase
{
    public function addSettingAction()
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

        if (!isset($obj->settings))
        {
            return[
                '_status' => false,
                '_error' => 'Пустая запись'
            ];
        }

        $data = (array) $obj->settings;

        if (empty($data))
        {
            return[
                '_status' => false,
                '_error' => 'Пустая запись'
            ];
        }

        foreach ($data as $key => $value)
        {
            $res = json_encode($value);
            $set = Settings::findFirst([
                'key = :key:',
                'bind' => [
                    'key' => $key
                ]
            ]);

            if ($set)
            {
                $set->value = $res;
                $set->save();
                continue;
            }

            $new_set = new Settings();
            $new_set->key = $key;
            $new_set->value = $res;
            $new_set->save();
        }
        return [
            '_status' => true
        ];
    }

    public function uploadPictureForMainPageAction()
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
        $src = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/img/' . $picture->file_name;
        $res = json_encode($src);
        $set = Settings::findFirst([
            'key = :key:',
            'bind' => [
                'key' => 'main_image'
            ]
        ]);

        if ($set)
        {
            $set->value = $res;
            $set->save();
            return [
                '_status' => true,
                'src' => $src
            ];
        }

        $new_set = new Settings();
        $new_set->key = 'main_image';
        $new_set->value = $res;
        $new_set->save();
        return [
            '_status' => true,
            'src' => $src
        ];
    }
}