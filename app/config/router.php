<?php

$router = $di->getRouter();

$router->add('/all-info','Index::getAll');

$router->handle();
