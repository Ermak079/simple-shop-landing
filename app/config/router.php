<?php

$router = $di->getRouter();

$router->add('/all-info','Products::getAll');
$router->add('/auth','Index::auth');
$router->add('/add-section','Sections::addSection',['POST']);
$router->add('/remove-section','Sections::removeSection',['POST']);
$router->add('/delete-section','Sections::deleteSection',['POST']);
$router->add('/add-product','Products::addProduct',['POST']);
$router->add('/remove-product','Products::removeProduct',['POST']);
$router->add('/delete-product','Products::deleteProduct',['POST']);
$router->add('/save-setting','Products::addSetting',['POST']);

$router->handle();
