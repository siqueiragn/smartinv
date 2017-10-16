<?php

/**
 * A implementação da classe AES é baseada na documentação oficial disponibilizada em 
 * http://php.net/manual/pt_BR/function.mcrypt-encrypt.php
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 */
class Aes
{

    private $key;

    public function __construct($key = LOGIN_CHAVE)
    {

    }


    /**
     * 
     * @param type $valor
     * @return type
     */
    public function crypt($valor)
    {

        return $valor;
    }

    public function decrypt($cript)
    {

        return $cript;
    }

}
