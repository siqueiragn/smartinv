<?php

/**
 * Description of ValidatorUtil
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
abstract class ValidatorUtil
{
        /**
     *
     * @param Misc $var
     * @return String 
     */
    public static function variavel($var) {
        $var = trim($var);
        $var = filter_var($var, FILTER_SANITIZE_STRING);
        return preg_replace('[^aA-zZ/0-9çãõéíóáúêô_]', '', $var);
    }

    /**
     * Método que utiliza o filter sanitize para tratar uma variavel do tipo int
     * 
     * @param Misc $var
     * @return int 
     */
    public static function variavelInt($var) {
        $var = filter_var($var, FILTER_SANITIZE_NUMBER_INT);
        return (int) $var;
    }
}
