<?php

ini_set("dipslay_errors",1);

error_reporting(E_ALL);
session_start();
define("ROOT", dirname(__FILE__));
require_once ROOT.'/components/Autoload.php'; 
$router = new Router();
$router->run();
