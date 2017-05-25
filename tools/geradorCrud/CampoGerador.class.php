<?php
/**
 * Classe que controla os campos, os tipos e os dados permitindo a fácil
 * manipulação deles
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 */
class CampoGerador {
    /**
     *Array associativo $chave => $valor para ser usado para substituições gerais tipo
     * agua => água
     *
     * @var Array
     */
    protected $dicionario = array();

    /**
     * Campos que devem ser ignorados na inserção
     *
     * @var Array
     */
    protected $camposIgnoreInsert = array(
        'data_cadastro'
    );

    /**
     * Campos que devem ser ignorados na consulta
     *
     * @var Array
     */
    protected $camposIgnoreJson = array();

    /**
     * Campos que devem ser ignorados nos templates
     *
     * @var Array
     */
    protected $camposIgnoreTemplates;

    /**
     *Variável que determina o nome do campo no formato de Banco de dados.
     * EX: data_coleta
     *
     * @var String
     */
    protected $nome;

    /**
     *Variável que apresenta o campo em formato camelCase
     * Ex: dataColeta
     *
     * @var String
     */
    protected $variavel;

    /**
     *Variável que apresenta o campo como apelido para formulários e etc
     * Ex: Data coleta
     *
     * @var String
     */
    protected $label;

    public function carregaIni(){
        $array = parse_ini_file(__DIR__ . '/../extras/dados.ini', true);
        $this->camposIgnoreTemplates = $array['ignores']['noTpl'];
        $this->dicionario = $array['dicionario'];
        //print_r($array);
    }

    public function ignorarEmTpl(){
        if(in_array($this->nome, $this->camposIgnoreTemplates)){
            return true;
        }else{
            return false;
        }
    }

    public function getNome() {
        return $this->nome;
    }

    /**
     * Método que retorna o nome da coluna no padrao nomeColuna
     *
     * @return String
     */
    public function getVariavel() {
        return $this->variavel;
    }

    public function getLabel() {
        return $this->label;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    public function setVariavel($variavel) {
        $this->variavel = $variavel;
        return $this;
    }

    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }


    protected function singulariza($palavra){
      StringUtil::singulariza($palavra);
    }

    /**
     * Gera nome do campo como Variavel e atribui para $this->variavel.
     *
     */
    protected function geraVariavelCamelCase() {
        $this->variavel = StringUtil::toCamelCase($this->nome);
    }

    /**
     * Gera nome do campo como apelido e atribui para $this->label.
     *
     */
    protected function geraLabel() {
        $aux = str_replace('_', ' ', $this->nome);
        foreach($this->dicionario as $str => $strSub){
            $aux = str_replace($str, $strSub, $aux);
        }
        $this->label = ucfirst($aux);
    }
 }
