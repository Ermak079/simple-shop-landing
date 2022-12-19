<?php

class ProductsController extends ControllerBase
{
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

        $section = Sections::findFirst();
        if(!$section){
            return[
                '_status' => false,
                '_error' => 'Не создано ни одной секции'
            ];
        }

        $product = new Products();
        $product->name = "Новый товар";
        $product->section_id = $section->id;
        $product->save();
        $product->refresh();
        return [
            '_status' => true,
            'section' => $product->toApi(),
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
        $prod_name = $obj->product_name ?? false;
        $count = $obj->amount ?? false;
        $price = $obj->cost ?? false;
        $section = $obj->section_id ?? false;
        $flag = false;
        if ($section)
        {
            $product->section_id = $section;
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
