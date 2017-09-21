<?php

/**
 * Description of TituloTabelaGerador
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 */
class TituloTabelaGerador extends CampoGerador {

    public function __construct($nome) {
        $this->carregaIni();
        $this->nome = $nome;
        $this->geraLabel();
        $this->geraVariavelCamelCase();
    }

}
