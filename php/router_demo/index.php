<?php
require 'router.php';
use component\Router;

$router = new Router();

$router->add('/^user/',function(){
		echo "it work";
});
$router->run();

