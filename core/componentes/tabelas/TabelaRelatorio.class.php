<?php

Componente::carregaComponente('Tabela');
Componente::carregaComponente('TabelaColuna');

/**
 * Classe que implementa o componente tabela dinamica. Este componente cria uma 
 * tabela a partir de dados de JSON, os dados podem originar de diversas consultas 
 * distintas e um dos principais objetivos desta implementação é contemplar resultados
 * e relatórios.
 * 
 * @package controlador.componentes
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 */
class TabelaRelatorio extends Tabela
{

    private $imprimir;
    private $exportarPdf;
    private $gerarCsv;
    private $gerarGrafico;
    private $gerarGraficoSemConfirmacao;
    private $idTabela;
    private $editar;
    private $deletar;
    private $filtrar;

    public function __construct($id = 0, $idTabela = "consulta")
    {
        parent::__construct('tabela[' . $id . ']');
        $this->idTabela = $idTabela;
        $this->imprimir = false;
        $this->exportarPdf = false;
        $this->gerarCsv = false;
        $this->gerarGrafico = false;
        $this->gerarGraficoSemConfirmacao = false;
        $this->editar = false;
        $this->deletar = false;
        $this->script = $this->variavel . ' = new Object(); ';
        $this->setSelecaoSimples(true);
        $this->filtrar = false;
    }

    public function add()
    {
        $this->adicionaComponente($this->view);
    }

    public function adicionaComponente(AbstractView $view)
    {
        parent::adicionaComponente($view);
        $this->getBotoes();

        $this->script .= $this->variavel . '.idTabela = "' . $this->idTabela . '"; ';
        $this->script .= $this->variavel . '.filtrar = ' . $this->getFiltrar() . PHP_EOL;
        $this->script .= $this->ordenavel . PHP_EOL;



        if (!self::$adicionado) {
            $this->script = 'var tabela = new Array();' . $this->script;

            if ($view->CDN()->isAdd('bootstrap')) {
                $view->addLibCss('componentes/tabela/tabela_bootstrap');
            } else {
                $view->addLibCss('componentes/tabela/tabela');
            }
            $view->addLibJS('jqgrid/main');
            $view->addLibJS('componentes/tabela/tabela_relatorio');
        }
        self::$adicionado = true;
        $view->addSelfScript(
                $this->script . PHP_EOL .
                $this->colunas . PHP_EOL .
                $this->labelColunas);
    }

    public function addTemplatePadrao()
    {
        $this->view->addTemplate(CORE . 'view/templates/componentes/tabelas/tabela_relatorio');
        $this->view->attValue('ID_TABELA', $this->idTabela);
    }

    public function addAcaoGerarCSV($acao = 'padrao')
    {
        if ($acao == strtolower('padrao')) {
            $this->script .= $this->variavel . '.acaoGerarCSV = "padrao"; ';
        } else {
            $this->script .= $this->variavel . '.acaoGerarCSV = "' . $acao . '"; ';
        }
        $this->setGerarCSV(true);
    }

    public function addAcaoEditar($acao)
    {
        $this->script .= $this->variavel . '.acaoEditar = "' . $acao . '"; ';
        $this->setEditar(true);
    }

    public function addAcaoDeletar($acao)
    {
        $this->script .= $this->variavel . '.acaoDeletar = "' . $acao . '"; ';
        $this->setDeletar(true);
    }

    public function addAcaoImprimir($acao)
    {
        $this->script .= $this->variavel . '.acaoImprimir = "' . $acao . '"; ';
        $this->setImprimir(true);
    }

    public function addAcaoExportarPdf($acao = 'padrao')
    {
        if ($acao == strtolower('padrao')) {
            $this->script .= $this->variavel . '.acaoExportarPDF = "padrao"; ';
        } else {
            $this->script .= $this->variavel . '.acaoExportarPDF = "' . $acao . '"; ';
        }
        $this->setExportarPDF(true);
    }

    public function addAcaoGerarGrafico($acao)
    {
        $this->script .= $this->variavel . '.acaoGerarGrafico = "' . $acao . '"; ';
        $this->setGerarGrafico(true);
    }

    public function setGerarGraficoSemConfirmacao($confirmacao)
    {
        $this->gerarGraficoSemConfirmacao = $confirmacao;
    }

    public function getImprimir()
    {
        return $this->imprimir;
    }

    public function setImprimir($imprimir)
    {
        $this->imprimir = $imprimir;
    }

    public function getExportarPdf()
    {
        return $this->exportarPdf;
    }

    public function setExportarPdf($exportarPdf)
    {
        $this->exportarPdf = $exportarPdf;
    }

    public function getGerarCsv()
    {
        return $this->gerarCsv;
    }

    public function setGerarCsv($gerarCsv)
    {
        $this->gerarCsv = $gerarCsv;
    }

    public function getGerarGrafico()
    {
        return $this->gerarGrafico;
    }

    public function setGerarGrafico($gerarGrafico)
    {
        $this->gerarGrafico = $gerarGrafico;
    }

    /**
     * Método que retorna o valor da variável editar
     *
     * @return String - Valor da variável editar
     */
    public function getEditar()
    {
        return $this->editar;
    }

    /**
     * Método que seta o valor da variável editar
     *
     * @param String $editar - Valor da variável editar
     */
    public function setEditar($editar)
    {
        $this->editar = $editar;
        return true;
    }

    /**
     * Método que retorna o valor da variável Deletar
     *
     * @return String - Valor da variável Deletar
     */
    public function getDeletar()
    {
        return $this->deletar;
    }

    /**
     * Método que seta o valor da variável editar
     *
     * @param String $deletar - Valor da variável editar
     */
    public function setDeletar($deletar)
    {
        $this->deletar = $deletar;
        return true;
    }

    private function getBotoes()
    {
        if ($this->gerarCsv) {
            $this->script .= $this->variavel . '.botaoGerarCSV = true;';
        } else {
            $this->script .= $this->variavel . '.botaoGerarCSV = false;';
        }

        if ($this->imprimir) {
            $this->script .= $this->variavel . '.botaoImprimir = true;';
        } else {
            $this->script .= $this->variavel . '.botaoImprimir = false;';
        }

        if ($this->exportarPdf) {
            $this->script .= $this->variavel . '.botaoExportarPDF = true;';
        } else {
            $this->script .= $this->variavel . '.botaoExportarPDF = false;';
        }
        if ($this->gerarGrafico) {
            $this->script .= $this->variavel . '.botaoGerarGrafico = true;';
        } else {
            $this->script .= $this->variavel . '.botaoGerarGrafico = false;';
        }

        if ($this->gerarGraficoSemConfirmacao) {
            $this->script .= $this->variavel . '.gerarGraficoSemConfirmacao = true;';
        } else {
            $this->script .= $this->variavel . '.gerarGraficoSemConfirmacao = false;';
        }

        if ($this->editar) {
            $this->script .= $this->variavel . '.botaoEditar = true;';
        } else {
            $this->script .= $this->variavel . '.botaoEditar = false;';
        }

        if ($this->deletar) {
            $this->script .= $this->variavel . '.botaoDeletar = true;';
        } else {
            $this->script .= $this->variavel . '.botaoDeletar = false;';
        }
    }

    public function getFiltrar()
    {
        return $this->filtrar ? 'true;' : 'false;';
    }

    public function setFiltrar($filtrar)
    {
        $this->filtrar = $filtrar;
    }

}
