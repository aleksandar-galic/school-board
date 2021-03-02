<?php

require 'vendor/autoload.php';

// Routing
$router = new \Bramus\Router\Router();
require 'routes.php';
$router->run();
