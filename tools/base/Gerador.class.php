<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gerador
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
abstract class Gerador
{
    /**
     *
     * @var ConfiguracaoGerador 
     */
    protected $conf;
    
    public function __construct()
    {
        $this->requires();
        $this->conf = new ConfiguracaoGerador();
    }
        
    public function iniFile()
    {
        $array = parse_ini_file(__DIR__ . '/../extras/dados.ini', true);
        return $array;
    }
    
    public function requires(){        
        require_once __DIR__ . '/ConfiguracaoGerador.class.php';
    }
}
