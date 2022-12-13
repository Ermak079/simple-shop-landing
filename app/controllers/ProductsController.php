<?php

class ProductsController extends ControllerBase
{
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
            'sections' => $result
        ];
    }

    public function addProductAction()
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
        $product = new Products();
        $product->name = "Новый товар";
        $product->save();
        return [
            '_status' => true,
            'section' => $product->name
        ];
    }

    public function editProductAction()
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
        $prod_id = $obj->product_id;
        $product = Products::findFirst([
            'id = :id:',
            'bind' => [
                'id' => $prod_id
            ]
        ]);

        if (!$product){
            return [
                '_status' => false,
                '_error' => 'Нет такого товара'
            ];
        }
        $prod_name = $obj->product_name;
        $count = $obj->count;
        $price = $obj->price;
        $picture = $obj->picture_id;
        $section = $obj->section_id;
        $flag = false;
        if ($section)
        {
            $product->section_id = $section;
            $flag = true;
        }
        if ($picture)
        {
            $product->picture_id = $picture;
            $flag = true;
        }
        if ($count)
        {
            $product->count = $count;
            $flag = true;
        }
        if ($price)
        {
            $product->price = $price;
            $flag = true;
        }
        if ($prod_name)
        {
            $product->name = $prod_name;
            $flag = true;
        }
        if ($flag)
        {
            $product->save();
            return [
                '_status' => true,
                'product' => $product->toApi()

            ];
        } else {
            return [
                '_status' => false,
                '_error' => 'Нет данных для изменения продукта'
            ];
        }
    }

    public function deleteProductAction()
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
        $prod_id = $obj->product_id;
        $product = Products::findFirst([
            'id = :id:',
            'bind' => [
                'id' => $prod_id
            ]
        ]);
        if (!$product){
            return [
                '_status' => true
            ];
        }
        $product->delete();
        return [
            '_status' => true
        ];
    }

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

        $data = (array) $this->request->getJsonRawBody();

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

    public function uploadPictureForProductAction()
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
        $prod_id = $this->dispatcher->getParam('productId');
        $product = Products::findFirst('id = ' . $prod_id);
        $product->picture_id = $picture->id;
        $product->save();
        return [
            '_status' => true
        ];
    }


}
