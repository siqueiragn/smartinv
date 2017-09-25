<?php

require_once SYSTEM . '/libs/ObjetoInsercao.class.php';
/**
 * Description of Geometry
 *
 * @author Marcio Bigolin
 */
class Geometry implements ObjetoInsercao{
    protected $binario;
    protected $encode = 'hex';


    public function __construct($binario) {
        $this->binario = $binario;
    }
    
    public function codigoInsercao() {
        return "decode('" . $this->binario . "', '" . $this->encode . "')";
    }
}
