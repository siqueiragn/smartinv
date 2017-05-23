<?php

Componente::carregaComponente('Tabela');
Componente::carregaComponente('TabelaColuna');

/**
 * Classe responsável por criar a tabela para manter dados
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * 
 */
class TabelaManterDados extends Tabela
{

    private $deletar;
    private $adicionar;
    private $editar;

    public function __construct()
    {
        parent::__construct('tabelaManterDados');
        $this->adicionar = false;
        $this->editar = false;
        $this->deletar = false;
        $this->setSelecaoSimples(true);
    }

    public function add()
    {
        $this->adicionaComponente($this->view);
    }

    public function adicionaComponente(AbstractView $visualizador)
    {
        $this->getBotoes();

        $visualizador->addSelfScript($this->script .
                $this->colunas .
                $this->camposPesquisa .
                $this->labelColunas);

        if ($visualizador->CDN()->isAdd('bootstrap')) {
            $visualizador->addLibCss('componentes/tabela/tabela_bootstrap');
        } else {
            $visualizador->addLibCss('componentes/tabela/tabela');
        }
        $visualizador->addLibJS('jqgrid/main');
        $visualizador->addLibJS('componentes/tabela/tabela_manter_dados');

        $visualizador->addTemplate(CORE . 'view/templates/componentes/tabelas/tabela_manter_dados', true);
        $visualizador->attValue('ID_TABELA', 'ManterDados');
    }

    /**
     * Método para adicionar titula a tabela para manter os dados
     *
     * @param String $titulo
     */
    public function setTitulo($titulo)
    {
        $this->script .= 'tabelaManterDados.titulo = "' . $titulo . '";';
    }

    /**
     * Método que indica qual vai ser a ação tomada ao se solicitar a deletação de
     * um dado.
     *
     *
     * @param URL $acao
     */
    public function addAcaoDeletar($acao)
    {
        $this->script .= 'tabelaManterDados.acaoDeletarDado = "' . $acao . '";';
        $this->setDeletar(true);
    }

    public function addAcaoEditar($acao)
    {
        $this->script .= 'tabelaManterDados.acaoEditarDado = "' . $acao . '";';
        $this->setEditar(true);
    }

    public function addAcaoAdicionar($acao)
    {
        $this->script .= 'tabelaManterDados.acaoAdicionarDado = "' . $acao . '";';
        $this->setAdicionar(true);
    }

    public function setDeletar($deletar)
    {
        $this->deletar = $deletar;
    }

    public function setAdicionar($adicionar)
    {
        $this->adicionar = $adicionar;
    }

    public function setEditar($editar)
    {
        $this->editar = $editar;
    }

    private function getBotoes()
    {
        if ($this->deletar) {
            $this->script .= 'tabelaManterDados.botaoDeletar = true;';
        } else {
            $this->script .= 'tabelaManterDados.botaoDeletar = false;';
        }

        if ($this->editar) {
            $this->script .= 'tabelaManterDados.botaoEditar = true;';
        } else {
            $this->script .= 'tabelaManterDados.botaoEditar = false;';
        }

        if ($this->adicionar) {
            $this->script .= 'tabelaManterDados.botaoAdicionar = true;';
        } else {
            $this->script .= 'tabelaManterDados.botaoAdicionar = false;';
        }
    }

//    public function addCampoPesquisa($tabelaCampoPesquisa) {
//
//    }
}
