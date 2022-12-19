<?php

$router = $di->getRouter();

$router->add('/all-info','Index::getAll');
$router->add('/auth','Index::auth');
$router->add('/add-section','Sections::addSection',['POST']);
$router->add('/edit-section','Sections::editSection',['POST']);
$router->add('/delete-section','Sections::deleteSection',['POST']);
$router->add('/add-product','Products::addProduct',['POST']);
$router->add('/edit-product','Products::editProduct',['POST']);
$router->add('/delete-product','Products::deleteProduct',['POST']);
$router->add('/save-setting','Settings::addSetting',['POST']);
$router->add('/upload-picture/product/{productId:[0-9]+?}','Products::uploadPictureForProduct',['POST']);
$router->add('/upload-picture/section/{sectionId:[0-9]+?}','Sections::uploadPictureForSection',['POST']);
$router->add('/upload-picture/main-page','Settings::uploadPictureForMainPage',['POST']);

$router->handle();
