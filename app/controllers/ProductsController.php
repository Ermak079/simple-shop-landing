<?php

class ProductsController extends ControllerBase
{
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

    public function removeProductAction()
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
        $prod_name = $obj->prouct_name;
        $product = Products::findFirst([
            'product_name = :product_name:',
            'bind' => [
                'product_name' => $prod_name
            ]
        ]);

        if (!$product){
            return [
                '_error' => 'Нет такого товарова -> ' . $prod_name
            ];
        }
        $old_name = $product->name;
        $new_prod_name = $obj->new_product_name;
        $product->name = $new_prod_name;
        $product->save();

        return [
            '_status' => true,
            'old_name' => $old_name,
            'new_name' => $product->name
        ];
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
                '_error' => 'Нет прав для данного действия'
            ];
        }
        $prod_name = $obj->product_name;
        $product = Products::findFirst([
            'name = :name:',
            'bind' => [
                'name' => $prod_name
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


}
