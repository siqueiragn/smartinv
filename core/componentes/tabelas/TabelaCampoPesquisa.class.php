<?php

/**
 * Esta classe serve para gerenciar e construir os itens de pesquisa do componente
 * de tabela usado no sistema.
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @package core.componentes.tabelas
 * @version  1.0.0 10/11/2013
 */
class TabelaCampoPesquisa
{

    private $nome;
    private $label;
    private $padrao;

    /**
     * Construtor da classe
     *
     * @param String $nome
     * @param String $label
     * @param Boolean $padrao
     */
    public function __construct($label, $nome, $padrao = false)
    {
        $this->nome = $nome;
        $this->label = $label;
        $this->setPadrao($padrao);
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getPadrao()
    {
        if ($this->padrao) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function setPadrao($padrao)
    {
        if ($padrao) {
            $this->padrao = true;
        } else {
            $this->padrao = false;
        }
    }

    public function __toString()
    {
        if ($this->padrao) {
            $string = 'isdefault: true,';
        } else {
            $string = '';
        }
        $string .= 'name: "' . $this->nome . '", ';
        $string .= 'display: "' . $this->label . '"';
        return $string;
    }

}
