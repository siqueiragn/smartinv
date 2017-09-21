<?php

/**
* Transforma erro em exceção.
*/
function logErro( $num, $str, $file, $line, $context = null ){
       
    $handler = new ErrorHandler();
    $handler->logarExcecao( new ErrorException( $str, 0, $num, $file, $line ) );
}

function logExcecao($e){
    $handler = new ErrorHandler();
    $handler->logarExcecao($e);
}

/**
* Checks for a fatal error, work around for set_error_handler not working on fatal errors.
*/
function checkFatal(){
    
    $error = error_get_last();
    if ( $error["line"] != 0 ){
        logErro( $error["type"], $error["message"], $error["file"], $error["line"] );
    }
}

