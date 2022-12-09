<?php

$router = $di->getRouter();

$router->add('/all-info','Products::getAll');
$router->add('/auth','Index::auth');
$router->add('/add-section','Sections::addSection',['POST']);
$router->add('/remove-section','Sections::removeSection',['POST']);
$router->add('/delete-section','Sections::deleteSection',['POST']);

$router->handle();
