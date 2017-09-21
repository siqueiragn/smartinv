<?php

/**
 * Description of StringUtil
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
abstract class StringUtil
{
    
    protected static $charMap = array(
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ç' => 'C',
        'É' => 'E', 'Ê' => 'E', 'Ì' => 'I', 'Í' => 'I',  
        'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ő' => 'O',
        'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ç' => 'c',
        'é' => 'e', 'ê' => 'e', 
        'í' => 'i', 'ñ' => 'n', 
        'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 
        'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u'

     
    );

    /**
     * Convert strings with underscores into CamelCase
     *
     * @param    string    $input    The string to convert
     * @return    string    The converted string
     */
    public static function toUnderscore($input)
    {
        $str = preg_replace('/(?!^)[[:upper:]][[:lower:]]/', '$0', preg_replace('/(?!^)[[:upper:]]+/', '_' . '$0', $input));
        return strtolower($str);
    }
    
    public static function underscoreNumber($input)
    {
        $text = self::toUnderscore($input);
        $text = preg_replace('/[0-9]+/', '_$0_', $text);
        $text = str_replace('__', '_', $text);
        return trim ($text, '_');
    }

    /**
     * Convert strings with underscores into CamelCase
     *
     * @param    string    $input    The string to convert
     * @param    bool    $first_char_caps    camelCase or CamelCase
     * @return    string    The converted string
     */
    public static function toCamelCase($input, $first_char_caps = false)
    {
        if ($first_char_caps == true) {
            $input[0] = strtoupper($input[0]);
        }
        $func = create_function('$c', 'return strtoupper($c[1]);');
        return preg_replace_callback('/_([a-z0-9])/', $func, $input);
    }
    
    public static function replaceByDictionary($string, $dicionario){
        $aux = str_replace('_', ' ', $string);
        foreach ($dicionario as $str => $strSub) {
            $aux = str_replace($str, $strSub, $aux);
        }
        return $aux;
    }
    
    /**
     * Função que remove acentuação das palavras exemplo.
     * função => funcao
     * 
     * @param String $string
     * @return String
     */
    public static function removeAcentuacao($string){
        return strtr($string, self::$charMap);
    }
    
    public static function extractLenght($stringCompleta, $textoSearch, $end = 1)
    {
        $pos = stripos($stringCompleta, $textoSearch);
        $str = substr($stringCompleta, $pos, strlen($textoSearch)+$end);
        $strRemove = str_replace($textoSearch, '', $str);
        $unit = trim($strRemove); // remove whitespaces
        return $unit;
    }

}
