<?php

spl_autoload_register('requireException');

function requireException($classe) {
    $arquivo =  __DIR__ . '/' . $classe .'.class.php'; 
    if(file_exists($arquivo)){
        require $arquivo;
    }
}