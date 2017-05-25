<?php

/**
 * Classe que gera o DataTransfer
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0.3
 */
class DataTransferGerador extends ArquivoGerador
{

    private $comTabela = true;
    private $interfaces;

    public function __construct()
    {
        $this->interfaces = ['DTOInterface'];
    }

    public function gerar()
    {
        $_confs = $this->config;

        $print = '<?php' . PHP_EOL;
        $print .= '/**' . PHP_EOL;
        $print .= ' * Classe para a transferencia de dados de ' . $this->nome . ' entre as ' . PHP_EOL;
        $print .= ' * camadas do sistema ' . PHP_EOL;
        $print .= ' *' . PHP_EOL;
        $print .= ' * @package app.model.dto' . PHP_EOL;
        $print .= ' * @author  ' . $_confs->getAutor() . ' <' . $_confs->getEmailAutor() . '> ' . PHP_EOL;
        $print .= ' * @version 1.0.0 - ' . date('d-m-Y') . '(Gerado Automaticamente com GC - ' . VERSAO . ')' . PHP_EOL;
        $print .= ' */' . PHP_EOL . PHP_EOL;

        $print .= " class " . $this->nome . " implements " . $this->verificaInterfaces() . PHP_EOL . ' {' . PHP_EOL;
        //Imprime as variaveis
        $print .= '    use core\\model\\DTOTrait;' . PHP_EOL . PHP_EOL;
        foreach ($this->tabela->getColunas() as $campo) {
            $print .= ( '    private $' . $campo->getVariavel() . ';' . PHP_EOL);
        }
        $print .= '    private $isValid;' . PHP_EOL;
        if ($this->comTabela) {
            $print .= '    private $table;' . PHP_EOL;
            //Imprime o construtor
            $print .= $this->geraConstrutor($this->tabela->getNomeCompleto());
        }


        //Imprime metodos get and Set
        foreach ($this->tabela->getColunas() as $i => $campo) {
            $print .= $this->geraGettersAndSetters($campo);
        }

        //imprime metodos auxiliares
        $print .= PHP_EOL;
        $print .= '    /**' . PHP_EOL;
        $print .= '     * Método que retorna o valor da variável $tabela ' . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     * @return String - Tabela do SGBD' . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '     public function getTable()' . PHP_EOL . '    {' . PHP_EOL;
        $print .= '        return $this->table;' . PHP_EOL;
        $print .= '     }' . PHP_EOL;
        $print .= PHP_EOL;
        $print .= '     public function setTable($table)' . PHP_EOL . '    {' . PHP_EOL;
        $print .= '        $this->table = $table;' . PHP_EOL;
        $print .= '     }' . PHP_EOL;
        $print .= PHP_EOL;

        $print .= $this->getArrayJson();

         $print .= $this->getID();
        $print .= $this->getCondicao();
        $print .= '}' . PHP_EOL;
        return $print;
    }

    private function getArrayJson()
    {
        $print  = '    /**' . PHP_EOL;
        $print .= '     * Método responsável por retornar um array em formato JSON ' . PHP_EOL;
        $print .= '     * para poder ser utilizado como Objeto Java Script' . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     * @return Array -  Array JSON' . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '     public function getArrayJSON()' . PHP_EOL . '     {' . PHP_EOL;
        $print .= '        return array(' . PHP_EOL;
        $flag = 1;
        foreach ($this->tabela->getColunas() as $campo) {
            if ($flag) {
                $print .= '             $this->' . $campo->getVariavel();
                $flag = 0;
            } else {
                $print .= ',' . PHP_EOL . '             $this->' . $campo->getVariavel();
            }
        }
        $print .= PHP_EOL;
        $print .= '        );' . PHP_EOL;
        $print .= '     }' . PHP_EOL;
        $print .= PHP_EOL;
        return $print;
    }

    /**
     *
     * @param String $tabela
     * @return string
     */
    private function geraConstrutor($tabela)
    {
        $print = PHP_EOL;
        $print .= '    /**' . PHP_EOL;
        $print .= '     * Método Construtor da classe responsável por setar a tabela ' . PHP_EOL;
        $print .= '     * e inicializar outras variáveis' . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     * @param String $table -  Nome da tabela no banco de dados' . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '    public function __construct($table = ' . "'$tabela'" . ')' . PHP_EOL;
        $print .= '    {' . PHP_EOL;
        $print .= '        $this->table = $table;' . PHP_EOL;
        if($this->tabela->possuiCamposGeograficos()){
            $print .= '        core\\libs\\geo\\Geo::load();'. PHP_EOL;
        }
        $print .= '    }' . PHP_EOL;
        return $print;
    }

    private function geraGettersAndSetters($campo)
    {
        $print = PHP_EOL;
        $print .= '    /**' . PHP_EOL;
        $print .= '     * Método que retorna o valor da variável ' . $campo->getVariavel() . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     * @return ' . $campo->getTipoPHP() . ' - Valor da variável ' . $campo->getVariavel() . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '    public function get' . ucfirst($campo->getVariavel()) . '()' . PHP_EOL . '     {' . PHP_EOL;
        $print .= '        return $this->' . $campo->getVariavel() . ';' . PHP_EOL;
        $print .= '    }' . PHP_EOL;
        $print .= $this->getCampoData($campo);

        $print .= PHP_EOL;
        $print .= '    /**' . PHP_EOL;
        $print .= '     * Método que seta o valor da variável ' . $campo->getVariavel() . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     * @param ' . $campo->getTipoPHP() . ' $' . $campo->getVariavel() . ' - Valor da variável ' . $campo->getVariavel() . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '    public function set' . ucfirst($campo->getVariavel()) . '(' . $campo->getTipagem() . '$' . $campo->getVariavel() . ')' . PHP_EOL . '    {' . PHP_EOL;
        $print .= $campo->getValidacaoPHP();
        $print .= '    }' . PHP_EOL;
        return $print;
    }

    private function getCampoData($campo)
    {
        $print = '';
        if (stripos($campo, 'data') !== false) {
            $print .= PHP_EOL;
            $print .= '    /**' . PHP_EOL;
            $print .= '     * Método que retorna o valor da variável ' . $campo->getVariavel() . ' formatada ' . PHP_EOL;
            $print .= '     *' . PHP_EOL;
            $print .= '     * @return String - Valor da variável ' . $campo->getVariavel() . ' formatada ' . PHP_EOL;
            $print .= '     */' . PHP_EOL;
            $print .= '    public function get' . ucfirst($campo->getVariavel()) . 'Formatada($extenco = true)' . PHP_EOL . '     {' . PHP_EOL;
            $print .= ( '        return  Util::formataData($this->' . $campo->getVariavel() . ');' . PHP_EOL);
            $print .= ( '    }' . PHP_EOL);
        }
        return $print;
    }

    private function verificaInterfaces()
    {
        foreach ($this->tabela->getColunas() as $coluna) {
            if ($coluna->getTipo() == 'oid' || $coluna->getTipo() == 'bytea') {
               // $this->interfaces['ObjetoInsercao'] = 'ObjetoInsercao';
            }
        }
        $interfaces = '';

        foreach ($this->interfaces as $in) {
            $interfaces .= $in . ', ';
        }

        return rtrim($interfaces, ', ');
    }

    private function getID()
    {
        if (!$this->comTabela) {
            return false;
        }
        $print = PHP_EOL;
        $print .= '    /**' . PHP_EOL;
        $print .= '     * Método utilizado como condição de seleção de chave primária' . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     * @return String - Condição para selecionar um dado unico na tabela' . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '     public function getID(){' . PHP_EOL;
        $chave = '';
        if(sizeof($this->tabela->getChavePrimaria()) == 1){
            $chaves = $this->tabela->getChavePrimaria();    
            $campo = reset($chaves);
            $chave = '$this->' . $campo->getVariavel();
        }elseif(sizeof($this->tabela->getChavePrimaria()) == 0){
            echo '[Warning] - Tabela ' . ' possivelmente modelada errada - (sem chave primária)';
            $chave = 'false';
        }else{// chave composta
            #TODO
        }
        $print .= "        return " . $chave . ';' . PHP_EOL;

        $print .= '     }' . PHP_EOL;
        return $print;
    }

    private function getCondicao()
    {
        if (!$this->comTabela) {
            return false;
        }
        $print = PHP_EOL;
        $print .= '    /**' . PHP_EOL;
        $print .= '     * Método utilizado como condição de seleção de chave primária' . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     * @return String - Condição para selecionar um dado unico na tabela' . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '    public function getCondition()' . PHP_EOL . '    {' . PHP_EOL;
        $condicao = '';
        foreach ($this->tabela->getChavePrimaria() as $campo) {
            $condicao .= $campo->getNome() . " = ' . \$this->" . $campo->getVariavel() . ".' AND " ;
        }
        $condicao = rtrim($condicao, ".' AND ");
        $print .= "        return '" . $condicao . ';' . PHP_EOL;

        $print .= '     }' . PHP_EOL;
        return $print;
    }
    
    

}
