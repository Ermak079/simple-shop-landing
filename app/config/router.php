<?php

$router = $di->getRouter();

$router->add('/all-info','Products::getAll');
$router->add('/auth','Index::auth');
$router->add('/add-section','Sections::addSection',['POST']);
$router->add('/edit-section','Sections::editSection',['POST']);
$router->add('/delete-section','Sections::deleteSection',['POST']);
$router->add('/add-product','Products::addProduct',['POST']);
$router->add('/edit-product','Products::editProduct',['POST']);
$router->add('/delete-product','Products::deleteProduct',['POST']);
$router->add('/save-setting','Products::addSetting',['POST']);
$router->add('/upload-picture/product/{productId:[0-9]+?}','Products::uploadPictureForProduct',['POST']);
$router->add('/upload-picture/section/{sectionId:[0-9]+?}','Sections::uploadPictureForSection',['POST']);

$router->handle();
