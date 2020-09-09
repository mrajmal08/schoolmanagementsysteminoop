<?php

spl_autoload_register(function($className) {
    $parts = explode('\\', $className);
    require "../classess/".end($parts) . ".php";

});

//spl_autoload_register(function($className) {
//    require '../classess/' .$className . '.php';
//
//});