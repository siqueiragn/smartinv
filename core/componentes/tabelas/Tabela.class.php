<?php

/**
 * A classe Tabela
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @package core.componentes.tabelas
 * @version  1.0.0 10/11/2013
 */
abstract class Tabela extends Componente {

    protected $script;
    protected $colunas;
    protected $labelColunas;
    protected $camposPesquisa;
    protected $variavel;
    protected $selecaoSimples;
    protected $selecaoMultipla;
    protected $altura;
    protected $ordenavel;

    /**
     * Construtor da Classe Tabela
     *
     * @param String $variavel - Variável para o script Java Script
     */
    public function __construct($variavel) {
        $this->variavel = $variavel;
        $this->script = 'var ' . $this->variavel . ' = new Object(); ';
        $this->colunas = $this->variavel . '.colunas = new Array(); ';
        $this->labelColunas = $this->variavel . '.labelsColunas = new Array(); ';
        $this->camposPesquisa = $this->variavel . '.camposPesquisa = new Array(); ';
        $this->ordenavel = $this->variavel . '.ordenavel = true;';
        $this->altura = 50;
    }

    public function setSelecaoSimples($selecao) {
        if ($selecao == true) {
            $this->script .= $this->variavel . '.selecaoMultipla = false; ';
            $this->script .= $this->variavel . '.selecaoSimples = true; ';
        } else {
            $this->script .= $this->variavel . '.selecaoMultipla = true; ';
            $this->script .= $this->variavel . '.selecaoSimples = false; ';
        }
    }

    public function addCampoPesquisa() {

    }

    public function setOrdenavel($ordenavel) {
        if ($ordenavel) {
            $this->ordenavel = $this->variavel . '.ordenavel = true;';
        } else {
            $this->ordenavel = $this->variavel . '.ordenavel = false;';
        }
    }

    public function addColuna(TabelaColuna $coluna) {
        $this->colunas .= $this->variavel . '.colunas.push({' . $coluna . '}); ';
        $this->labelColunas .= $this->variavel . '.labelsColunas.push("' . $coluna->getLabel() . '"); ' . PHP_EOL;
    }

    public function setDados($dados) {
        $this->script .= $this->variavel . '.dados = "' . $dados . '";';
    }

    public function setTitulo($titulo) {
        $this->script .= $this->variavel . '.titulo = "' . $titulo . '";';
    }

    public function getAltura() {
        return $this->altura;
    }

    public function setAltura($altura) {
        $this->altura = $altura;
    }

    public function adicionaComponente(AbstractView $visualizador) {
        $this->script .= $this->variavel . '.altura = "' . $this->altura . '";';
    }

}
