<?php

/**
 * Description of DebugUtil
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
class DebugUtil
{

    public static function show($misc){
        echo '<pre>';
        if(is_array($misc) || is_object($misc)){
            print_r($misc);
        }else{
            var_dump($misc);
        }
        echo '</pre>';
    }
    
    public static function remoteShow($misc){
        ob_start(); 
        self::show($misc);
        $result = ob_get_clean();
        MailUtil::debugMail($from, $dest, $title, $message);
    }
}
