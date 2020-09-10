<?php

spl_autoload_register(function($className) {
    $parts = explode('\\', $className);
    $file = "../classess/".end($parts) . ".php";
    if(file_exists($file)){
        require $file;
    }
});

//spl_autoload_register(function($className) {
//    require '../classess/' .$className . '.php';
//
//});