<?php

/**
 * Classe responsável por criar o controlador
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 */
class ControleRelatorio
{

    private $colunas;

    /**
     *
     * @var View 
     */
    private $view;

    /**
     *
     * @var ConfiguracaoGerador 
     */
    private $config;

    public function __construct(View $view, ConfiguracaoGerador $config)
    {
        $this->view = $view;
        $this->config = $config;
    }

    public function gerar()
    {
        $print = '<?php' . PHP_EOL;

        $print .= PHP_EOL;
        $print .= '/**' . PHP_EOL;
        $print .= ' * Classe controladora referente ao relatório ' . $this->view->getLabel() . PHP_EOL;
        $print .= ' *' . PHP_EOL;
        $print .= ' * @package app.control' . $this->view->getModulo() . PHP_EOL;
        $print .= ' * @author ' . $this->config->getAutor() . ' <' . $this->config->getEmailAutor() . '>' . PHP_EOL;
        $print .= ' * @version 1.0.0 - ' . date('d-m-Y') . '(Gerado automaticamente - GR - ' . VERSAO . ')' . PHP_EOL;
        $print .= ' */' . PHP_EOL . PHP_EOL;
        $print .= 'class Controlador' . $this->view->getNomeCamelCase() . ' extends ' . $this->controladorPai() . ' {' . PHP_EOL;
        $print .= PHP_EOL;
        $print .= $this->construtor();
        $print .= PHP_EOL;
        $print .= '     /**' . PHP_EOL;
        $print .= '      * Método que cria a view que serve de visualização para os dados.  ' . PHP_EOL;
        $print .= '      * através dessa página pode se acessar as demans funcionalidades do CRUD.  ' . PHP_EOL;
        $print .= '      *' . PHP_EOL;
        $print .= '      */' . PHP_EOL;
        $print .= '    public function index() {' . PHP_EOL;
        $print .= "        \$this->view->setTitle('" . $this->view->getLabel() . "');" . PHP_EOL;
        $print .= "        \$this->view->setDescription('" . $this->view->getComentario() . "');" . PHP_EOL;
        $print .= PHP_EOL;
        $print .= "        Componente::carregaComponente('TabelaRelatorio'); " . PHP_EOL;
        $print .= '        $tabela = new TabelaRelatorio();' . PHP_EOL;
        $print .= "        \$tabela->setDados(BASE_URL . '/relatorios/" . $this->geraCaminho() . "/getJson');" . PHP_EOL;
        $print .= "        \$tabela->setTitulo('" . $this->view->getLabel() . "');" . PHP_EOL;

        $print .= PHP_EOL;

        $print .= '         //Colunas da view' . PHP_EOL;
        $listaDeSelects = array();
        foreach ($this->view->getColunas() as $i => $campo) {

            if ($campo->getTipo() != 'oid') {
                $print .= "        \$viewColuna = new TabelaColuna('" . $campo->getLabel() . "', '" . $campo->getNome() . "');" . PHP_EOL;
                $print .= '        $viewColuna->setLargura(' . $campo->getTamanhoCampo() . ');' . PHP_EOL;
                $print .= '        $viewColuna->setBuscaTipo(' . "'" . $campo->getTipo() . "'" . ');' . PHP_EOL;
                $print .= '        $tabela->addColuna($viewColuna);' . PHP_EOL;
                $print .= PHP_EOL;
            }
        }

        $print .= '        $this->view->addComponente($tabela);' . PHP_EOL;
        $print .= '        $tabela->addTemplatePadrao();' . PHP_EOL;

        $print .= '    }' . PHP_EOL;

        $print .= $this->view();


        $print .= '}';
        $print .= PHP_EOL;
        return $print;
    }

    private function construtor()
    {
        $print = '     /**' . PHP_EOL;
        $print .= '      * Construtor da classe ' . $this->view->getNome() . ', esse método inicializa o  ' . PHP_EOL;
        $print .= '      * modelo de dados ' . PHP_EOL;
        $print .= '      *' . PHP_EOL;
        $print .= '      */' . PHP_EOL;
        $print .= '    public function __construct() {' . PHP_EOL;
        $print .= '        parent::__construct();' . PHP_EOL;
        $print .= '        $this->model = new ' . $this->view->getNomeCamelCase() . 'Model();' . PHP_EOL;


        $print .= '    }' . PHP_EOL;
        return $print;
    }

    private function view()
    {
        $print = PHP_EOL;
        $print .= '     /**' . PHP_EOL;
        $print .= '      * Método que gera os dados json da view  ' . $this->view->getNome() . PHP_EOL;
        $print .= '      * e recebe os dados de consulta para ordenação  ' . PHP_EOL;
        $print .= '      *' . PHP_EOL;
        $print .= '      */' . PHP_EOL;
        $print .= '    public function getJson() {' . PHP_EOL;
        $print .= '        $this->view->setRenderizado();' . PHP_EOL;
        $print .= "        Componente::carregaComponente('TabelaConsulta');" . PHP_EOL;
        $print .= "        \$view = new TabelaConsulta(ValidatorUtil::variavel(\$_POST['sidx']));" . PHP_EOL;
        $print .= '        $view->recebeDados($_POST);' . PHP_EOL;
        $print .= PHP_EOL;
        $print .= '        $dados = $this->model->getTabela($view);' . PHP_EOL;
        $print .= PHP_EOL;
        $print .= '        echo json_encode($dados);' . PHP_EOL;
        $print .= '    }' . PHP_EOL;
        $print .= PHP_EOL;
        return $print;
    }

    private function paginaNaoEncontrada()
    {
        $print  = '    /**' . PHP_EOL;
        $print .= '     * Método que gera os dados json da view  ' . $this->view->getNome() . PHP_EOL;
        $print .= '     * e recebe os dados de consulta para ordenação  ' . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '    public function paginaNaoEncontrada()' . PHP_EOL;
        $print .= '    {' . PHP_EOL;
        $print .= '        $this->index();' . PHP_EOL;
        $print .= '    }' . PHP_EOL;
    }

    private function controladorPai()
    {
        if (empty($this->view->getModulo())) {
            return 'ControladorGeral';
        } else {
            return 'Controlador' . ucfirst($this->view->getModulo());
        }
    }
    
    private function geraCaminho(){
        if (empty($this->view->getModulo())) {
            return $this->view->getNomeCamelCase() ;
        }else{
            return $this->view->getModulo() . '/'. $this->view->getNomeCamelCase() ;
        }
    }

}
