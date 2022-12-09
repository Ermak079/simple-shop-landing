<?php

$router = $di->getRouter();

$router->add('/all-info','Products::getAll');

$router->handle();
