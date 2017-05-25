<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Coluna
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
class Coluna
{
    private $nome;
    private $tipo;
    private $dicionario = array();
    
    public function __construct($nome)
    {
        $this->nome = $nome;
    }
    
    public function getNome()
    {
        return $this->nome;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }
    
    public function getDicionario()
    {
        return $this->dicionario;
    }

    public function setDicionario($dicionario)
    {
        $this->dicionario = $dicionario;
        return $this;
    }

        
    /**
     * Retorna o nome da coluna em formato de label formatado e acentuado conforme o dicionario.
     * 
     * @return String Nome Formatado.
     */
    public function getLabel()
    {
        return ucfirst(StringUtil::replaceByDictionary($this->nome, $this->dicionario));
    }
    
    public function getVariavel(){
        return StringUtil::toCamelCase($this->nome);
    }
    
    /**
     * Retorna o tamanho que a coluna deverá ocupar aproximadamente de acordo com o tipo
     * 
     * @return int
     */
    public function getTamanhoCampo(){
           if ($this->tipo == 'int4' || $this->tipo == 'float' || $this->tipo == 'integer') {
            return 40;
        } else if ($this->tipo == 'text') {
            return 80;
        }
        return 60;
    }
    
    public function __toString()
    {
        return $this->nome;
    }


}
