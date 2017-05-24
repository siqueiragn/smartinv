<?php

/**
 * 
 * 
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 */
class EntradaDeDadosException extends Exception{
    #TODO implementar log para salvar a requisição que gerou essa exceção
    public function __construct($mensagem, $codigoErro = 10) {
        parent::__construct($mensagem, $codigoErro);
        $this->message = $mensagem;
        $this->code = $codigoErro;
    }

}