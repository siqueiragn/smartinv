<?php

/**
 * 
 * 
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 */
class ProgramacaoException extends Exception{
    #TODO implementar log para salvar o usuario e a data do programador que conseguir disparar essa exceção =]
    public function __construct($mensagem, $codigoErro = 10) {
        parent::__construct($mensagem, $codigoErro);
        $this->message = $mensagem;
        $this->code = $codigoErro;
        if(DEBUG)#easter egg se tiver em debug.
            echo '<script>alert("toiinn")</script>';
    }

}