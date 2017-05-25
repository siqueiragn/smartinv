<?php

/**
 * Superclasse abstrata dos arquivos que são geradas
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 2.0.2
 */
abstract class ArquivoGerador {
    /**
     *
     * @var ConfiguracaoGerador
     */
    protected $config;
    protected $campos;
    protected $tipos;
    protected $schema = '';
    protected $deletar = true;
    /**
     * Objeto que faz referência a um objeto do tipo TabelaGerador 
     * 
     * @var TabelaGerador 
     */
    protected $tabela = false;
    protected $modelo;
    protected $trait = false;
    protected $nome;


    public function setModelo(Modelo $modelo){
        $this->modelo = $modelo;
    }
    
    public function geraTabela($tabela){
        $this->tabela = new TabelaGerador($tabela);
        $this->tabela->carrega($this->modelo);
        $this->schema = $this->tabela->getSchema();
    }
    
    public function setTabela(TabelaGerador $tabela){
        $this->tabela = $tabela;
        $this->campos = $tabela->getColunas();
        $this->nome = $tabela->getNomeCamelCase();
        $this->schema = $this->tabela->getSchema();
    }

    abstract public function gerar();  

    public function getConfig() {
        return $this->config;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCampos() {
        return $this->campos;
    }

    public function getTipos() {
        return $this->tipos;
    }

    public function getSchema() {
        return $this->schema;
    }
    
        
    /**
     * Método que retorna o módulo ao qual o esquema está associado e caso o mesmo 
     * não esteja associado a nenhum módulo retorna o nome do esquema como módulo.
     * 
     */
    public function getModulo(){
       $esquemas = $this->config->getEsquemas();
       if(isset($esquemas[$this->tabela->getSchema()])){
           return $esquemas[$this->tabela->getSchema()];
       }else{
           return $this->tabela->getSchema();
       }
    }


    public function getDeletar() {
        return $this->deletar;
    }

    public function setConfig(ConfiguracaoGerador $config) {
        $this->config = $config;
        $this->deletar = $this->config->getDeletar();
        return $this;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    public function setCampos($campos) {
        $this->campos = $campos;
        return $this;
    }

    /**
     * 
     * @deprecated since version 1.2.0
     * @param Array $tipos
     * @return \ArquivoGerador
     */
    public function setTipos($tipos) {
        $this->tipos = $tipos;
        return $this;
    }

    public function setSchema($schema) {
        $this->schema = $schema;
        return $this;
    }

  
}
