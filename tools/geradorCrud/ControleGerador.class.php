<?php

/**
 * Classe responsável por criar o controlador
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 */
class ControleGerador extends ArquivoGerador
{

    public function gerar()
    {
        $print = '<?php' . PHP_EOL;

        $print .= PHP_EOL;
        $print .= '/**' . PHP_EOL;
        $print .= ' * Classe controladora referente ao objeto ' . $this->nome . ' para ' . PHP_EOL;
        $print .= ' * a manutenção dos dados no sistema ' . PHP_EOL;
        $print .= ' *' . PHP_EOL;
        $print .= ' * @package app.control' . $this->getModulo() . PHP_EOL;
        $print .= ' * @author ' . $this->config->getAutor() . ' <' . $this->config->getEmailAutor() . '>' . PHP_EOL;
        $print .= ' * @version 1.0.0 - ' . date('d-m-Y') . '(Gerado automaticamente - GC - ' . VERSAO . ')' . PHP_EOL;
        $print .= ' */' . PHP_EOL . PHP_EOL;
        $print .= 'class Controlador' . $this->tabela->getNomeCamelCase() . ' extends ' . $this->controladorPai(). PHP_EOL . ' {' . PHP_EOL;
        $print .= PHP_EOL;
        $print .= '    /**' . PHP_EOL;
        $print .= '     * @var ' . $this->tabela->getNomeCamelCase() . 'DAO' . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '    protected $model;' . PHP_EOL;
        $print .= PHP_EOL;
        $print .= $this->construtor();
        $print .= PHP_EOL;
        $print .= '     /**' . PHP_EOL;
        $print .= '      * Método que redireciona para a página de manter dados  ' . PHP_EOL;
        $print .= '      *' . PHP_EOL;
        $print .= '      */' . PHP_EOL;
        $print .= '    public function index()' . PHP_EOL .'    {' . PHP_EOL;
        $print .= '        $this->manter();' . PHP_EOL;
        $print .= '    }' . PHP_EOL;
        $print .= PHP_EOL;
        $print .= '     /**' . PHP_EOL;
        $print .= '      * Método que cria a tabela que serve de visualização para os dados.  ' . PHP_EOL;
        $print .= '      * através dessa página pode se acessar as demans funcionalidades do CRUD.  ' . PHP_EOL;
        $print .= '      *' . PHP_EOL;
        $print .= '      */' . PHP_EOL;
        $print .= '    public function manter()' . PHP_EOL .'    {' . PHP_EOL;
        $print .= "        \$this->view->setTitle('" . $this->tabela->getLabel() . "');" . PHP_EOL;
        $print .= PHP_EOL;
        $print .= "        Componente::carregaComponente('TabelaManterDados'); " . PHP_EOL;
        $print .= '        $tabela = new TabelaManterDados();' . PHP_EOL;
        $print .= "        \$tabela->setDados(BASE_URL . '" . $this->montaEndereco($this->getModulo(), $this->tabela->getNomeCamelCase()) . "tabela');" . PHP_EOL;
        $print .= "        \$tabela->setTitulo('" . $this->tabela->getLabel() . "');" . PHP_EOL;
        $print .= "        \$tabela->addAcaoAdicionar(BASE_URL . " . PHP_EOL;
        $print .= "        '" . $this->montaEndereco(lcfirst($this->getModulo()), lcfirst($this->tabela->getNomeCamelCase())) . "criarNovo');" . PHP_EOL;
        $print .= "        \$tabela->addAcaoEditar(BASE_URL . " . PHP_EOL;
        $print .= "        '" . $this->montaEndereco(lcfirst($this->getModulo()), lcfirst($this->tabela->getNomeCamelCase())) . "editar');" . PHP_EOL;
        if ($this->config->isDeletar()) {
            $print .= "        \$tabela->addAcaoDeletar(BASE_URL . " . PHP_EOL;
            $print .= "        '" . $this->montaEndereco(lcfirst($this->getModulo()), lcfirst($this->tabela->getNomeCamelCase())) . "deletarFim');" . PHP_EOL;
        }
        $print .= PHP_EOL;

        $print .= '         //Colunas da tabela' . PHP_EOL;
        $listaDeSelects = array();
        foreach ($this->tabela->getColunas() as $i => $campo) {
            if ($campo->isChaveEstrangeira()) {
                $listaDeSelects[] = $campo;
            }

            if ($campo->getTipo() != 'oid') {
                $print .= "        \$tabelaColuna = new TabelaColuna('" . $campo->getLabel() . "', '" . $campo->getNome() . "');" . PHP_EOL;
                $print .= '        $tabelaColuna->setLargura(' . $campo->getTamanhoCampo() . ');' . PHP_EOL;
                $print .= '        $tabelaColuna->setBuscaTipo(' . "'" . $campo->getTipo() . "'" . ');' . PHP_EOL;
                $print .= '        $tabela->addColuna($tabelaColuna);' . PHP_EOL;
                $print .= PHP_EOL;
            }
        }

        $print .= '        $this->view->addComponente($tabela);' . PHP_EOL;
        $print .= '    }' . PHP_EOL;

        $print .= $this->tabela();
        $print .= $this->criarNovo();

        $print .= $this->editar();

        $print .= PHP_EOL;
        $print .= $this->criarNovoFim();
        $print .= PHP_EOL;
        $print .= $this->editarFim();
        $print .= PHP_EOL;

        if ($this->config->isDeLetar()) {
            $print .= $this->deletar();
        }

        $print .= $this->getSelects($listaDeSelects);

        $print .= $this->inserirArquivos();

        $print .= '}';
        $print .= PHP_EOL;
        return $print;
    }

    private function construtor(){
        $print = '     /**' . PHP_EOL;
        $print .= '      * Construtor da classe ' . $this->nome . ', esse método inicializa o  ' . PHP_EOL;
        $print .= '      * modelo de dados ' . PHP_EOL;
        $print .= '      *' . PHP_EOL;
        $print .= '      */' . PHP_EOL;
        $print .= '    public function __construct() {' . PHP_EOL;
        $print .= '        parent::__construct();' . PHP_EOL;
        $print .= '        $this->model = new ' . $this->tabela->getNomeCamelCase() . 'DAO();' . PHP_EOL;

        $print .= '    }' . PHP_EOL;
        return  $print;
    }

    private function tabela()
    {
        $print = PHP_EOL;
        $print .= '     /**' . PHP_EOL;
        $print .= '      * Método que gera os dados json da tabela de manutenção dos dados ' . PHP_EOL;
        $print .= '      * e recebe os dados de consulta para a sua atualizacao ' . PHP_EOL;
        $print .= '      *' . PHP_EOL;
        $print .= '      */' . PHP_EOL;
        $print .= '    public function tabela()' . PHP_EOL . '     {' . PHP_EOL;
        $print .= '        $this->view->setRenderizado();' . PHP_EOL;
        $print .= "        Componente::carregaComponente('TabelaConsulta');" . PHP_EOL;
        $print .= "        \$tabela = new TabelaConsulta(ValidatorUtil::variavel(\$_POST['sidx']));" . PHP_EOL;
        $print .= '        $tabela->recebeDados($_POST);' . PHP_EOL;
        $print .= PHP_EOL;
        $print .= '        $dados = $this->model->getTabela($tabela);' . PHP_EOL;
        $print .= PHP_EOL;
        $print .= '        echo json_encode($dados);' . PHP_EOL;
        $print .= '    }' . PHP_EOL;
        $print .= PHP_EOL;
        return $print;
    }

    private function criarNovo()
    {
        $print = PHP_EOL;
        $print .= '     /**' . PHP_EOL;
        $print .= '      * Método que controla a inserção de um novo dado' . PHP_EOL;
        $print .= '      *' . PHP_EOL;
        $print .= '      * @param ' . $this->tabela->getNomeCamelCase() . ' $obj - Objeto DataTransfer com os dados da classe' . PHP_EOL;
        $print .= '      */' . PHP_EOL;
        $print .= '    public function criarNovo(' . $this->tabela->getNomeCamelCase() . ' $obj = null)' . PHP_EOL . '     {' . PHP_EOL;
        $print .= '        $' . lcfirst($this->tabela->getNomeCamelCase()) . ' = $obj == null ? new ' . $this->tabela->getNomeCamelCase() . '() : $obj;' . PHP_EOL;
        $print .= PHP_EOL;
        $print .= "        \$this->view->setTitle('Novo " . $this->tabela->getLabel() . "');" . PHP_EOL;
        $print .= PHP_EOL;
        $print .= "        \$this->view->attValue('" . lcfirst($this->tabela->getNomeCamelCase()) . "', \$" . lcfirst($this->tabela->getNomeCamelCase()) . ");" . PHP_EOL;
        $print .= PHP_EOL;
        $print .= "        //Carrega os campos de seleção;" . PHP_EOL;
        $print .= "        \$this->getSelects();" . PHP_EOL;
        $print .= "        \$this->view->startForm(BASE_URL " . " . '" . $this->montaEndereco(lcfirst($this->getModulo()), lcfirst($this->tabela->getNomeCamelCase())) . "criarNovoFim');" . PHP_EOL;
        $print .= "        \$this->view->addTemplate('{$this->getPathModulo()}forms/" . $this->tabela->getNomeTabela() . "');" . PHP_EOL;
        $print .= "        \$this->view->endForm();" . PHP_EOL;
        $print .= '    }' . PHP_EOL;
        $print .= PHP_EOL;
        return $print;
    }

    private function criarNovoFim()
    {
        $print = '    /**' . PHP_EOL;
        $print .= '     * Método que controla a criação e inserção de um dado no SGBD' . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '    public function criarNovoFim()' . PHP_EOL . '     {' . PHP_EOL;
        $print .= '        $' . lcfirst($this->tabela->getNomeCamelCase()) . ' = new ' . $this->tabela->getNomeCamelCase() . '();' . PHP_EOL;
        $print .= '        try {' . PHP_EOL;
        $print .= "            unset(\$_POST['id".$this->tabela->getNomeCamelCase()."']);" . PHP_EOL;
        $print .= '            if($' . lcfirst($this->tabela->getNomeCamelCase()) . '->setArrayDados($_POST) > 0){ ' . PHP_EOL;
        $print .= "                \$this->view->addErros(\$GLOBALS['ERROS']);" . PHP_EOL;
        $print .= '            }else{' . PHP_EOL;
        $print .= '                if($this->model->create($' . lcfirst($this->tabela->getNomeCamelCase()) . ')){' . PHP_EOL;
        $print .= "                    \$this->view->addMensagemSucesso('Dados inseridos com sucesso!');" . PHP_EOL;
        $print .= '                    $this->manter();' . PHP_EOL;
        $print .= '                    return ;' . PHP_EOL;
        $print .= '                }else{' . PHP_EOL;
        $print .= "                    \$this->view->addMensagemErro('Erro ao inserir seus dados tente novamente mais tarde.');" . PHP_EOL;
        $print .= '                }' . PHP_EOL;
        $print .= '            }' . PHP_EOL;
        $print .= '        }catch (IOErro $e){ ' . PHP_EOL;
        $print .= "             \$erro  = 'Ocorreu um erro pouco comum. O mesmo será cadastrado no ';" . PHP_EOL;
        $print .= "             \$erro .= 'sistema e solucionado o mais breve possível.';" . PHP_EOL;
        $print .= '             $this->view->addMensagemErro($erro);' . PHP_EOL;
        $print .= '        }' . PHP_EOL;
        $print .= '        $this->criarNovo($' . lcfirst($this->tabela->getNomeCamelCase()) . ');' . PHP_EOL;
        $print .= '    }' . PHP_EOL;
        return $print;
    }

    private function editar(){
        $print = '    /**' . PHP_EOL;
        $print .= '     * Método edita os dados da tabela ou objeto em questão ' . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     * @param ' . $this->tabela->getNomeCamelCase() . ' $obj - Objeto para carregar os formulários ' . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '    public function editar(' . $this->tabela->getNomeCamelCase() . ' $obj = null) ' . PHP_EOL . '    {' . PHP_EOL;
        $print .= '        if($obj == null){' . PHP_EOL;
        $print .= "            \$id = ValidatorUtil::variavelInt(\$GLOBALS['ARGS'][0]);" . PHP_EOL;
        $print .= '            $' . lcfirst($this->tabela->getNomeCamelCase()) . ' = $this->model->getById($id);' . PHP_EOL;
        $print .= '        }else{' . PHP_EOL;
        $print .= '            $' . lcfirst($this->tabela->getNomeCamelCase()) . ' = $obj;' . PHP_EOL;
        $print .= '        }' . PHP_EOL;
        $print .= PHP_EOL;
        $print .= "        \$this->view->setTitle('Editar " . $this->tabela->getLabel() . "');" . PHP_EOL;
        $print .= PHP_EOL;
        $print .= "        \$this->view->attValue('" . lcfirst($this->tabela->getNomeCamelCase()) . "', \$" . lcfirst($this->tabela->getNomeCamelCase()) . ");" . PHP_EOL;

        $print .= PHP_EOL;
        $print .= "        //Carrega os campos de seleção;" . PHP_EOL;
        $print .= "        \$this->getSelects();" . PHP_EOL;

        $print .= PHP_EOL;
        $print .= "        \$this->view->startForm(BASE_URL . '" . $this->montaEndereco(lcfirst($this->getModulo()), lcfirst($this->tabela->getNomeCamelCase())) . "editarFim');" . PHP_EOL;
        $print .= "        \$this->view->addTemplate('" . $this->getPathModulo() . "forms/" . $this->tabela->getNomeTabela() . "');" . PHP_EOL;
        $print .= "        \$this->view->endForm();" . PHP_EOL;
        $print .= '    }' . PHP_EOL;
        return $print;
    }

    private function editarFim()
    {
        $print = '    /**' . PHP_EOL;
        $print .= '     * Método que controla a atualização na tabela ' . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '    public function editarFim()' . PHP_EOL . '     {' . PHP_EOL;
        $print .= '        $' . lcfirst($this->tabela->getNomeCamelCase()) . ' = new ' . $this->tabela->getNomeCamelCase() . '();' . PHP_EOL;
        $print .= "        \$id = ValidatorUtil::variavelInt(\$_POST['id" . $this->tabela->getNomeCamelCase() . "']);" . PHP_EOL;
        $print .= '        $' . lcfirst($this->tabela->getNomeCamelCase()) . '->setId' . $this->tabela->getNomeCamelCase() . '($id);' . PHP_EOL;
        $print .= '        try {' . PHP_EOL;
        $print .= '             if($' . lcfirst($this->tabela->getNomeCamelCase()) . '->setArrayDados($_POST) > 0){ ' . PHP_EOL;
        $print .= "                 \$this->view->addErros(\$GLOBALS['ERROS']);" . PHP_EOL;
        $print .= '             }else{' . PHP_EOL;
        $print .= '                 if($this->model->update($' . lcfirst($this->tabela->getNomeCamelCase()) . ')){' . PHP_EOL;
        $print .= "                     \$this->view->addMensagemSucesso('Dados alterados com sucesso!');" . PHP_EOL;
        $print .= '                     $this->manter();' . PHP_EOL;
        $print .= '                     return ;' . PHP_EOL;
        $print .= '                 }else{' . PHP_EOL;
        $print .= '                     $this->view->addMensagemErro($this->model->getErros());' . PHP_EOL;
        $print .= '                 }' . PHP_EOL;
        $print .= '             }' . PHP_EOL;
        $print .= '        }catch (IOErro $e){ ' . PHP_EOL;
        $print .= "             \$erro  = 'Ocorreu um erro pouco comum. O mesmo será cadastrado no ';" . PHP_EOL;
        $print .= "             \$erro .= 'sistema e solucionado o mais breve possível.';" . PHP_EOL;
        $print .= '             $this->view->addMensagemErro($erro);' . PHP_EOL;
        $print .= '        }' . PHP_EOL;
        $print .= '        $this->editar($' . lcfirst($this->tabela->getNomeCamelCase()) . ');' . PHP_EOL;
        $print .= '    }' . PHP_EOL;
        return $print;
    }

    private function getSelects($listaDeSelects)
    {
        $print = '    /**' . PHP_EOL;
        $print .= '     * Método que cria os select ' . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '    private function getSelects()' . PHP_EOL . '     {' . PHP_EOL;
        foreach ($listaDeSelects as $select) {
            $print .= "        \$consulta = \$this->model->queryTable('" . $select->getChaveEstrangeiraRelacao() . "', '" . $select . ", " . $select->getChaveEstrangeiraRelacao() . "');" . PHP_EOL;
            $print .= "        \$lista = \$this->model->getMapaSimplesDados(\$consulta, '$select', '" . $select->getChaveEstrangeiraRelacao() . "');" . PHP_EOL;

            $print .= "        \$this->view->attValue('lista" . StringUtil::toCamelCase($select->getChaveEstrangeiraRelacao(), true) . "', \$lista);" . PHP_EOL;
            $print .= PHP_EOL;
        }
        $print .= '    }' . PHP_EOL;

        return $print;
    }

    private function deletar()
    {
        $print = '    /**' . PHP_EOL;
        $print .= '     * Método que controla a exclusão de dados na tabela final' . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '    public function deletarFim()' . PHP_EOL .'    {' . PHP_EOL;
        $print .= '        $' . lcfirst($this->tabela->getNomeCamelCase()) . ' = new ' . $this->tabela->getNomeCamelCase() . '();' . PHP_EOL;
        $print .= "        \$id = ValidatorUtil::variavelInt(\$GLOBALS['ARGS'][0]);" . PHP_EOL;
        $print .= '        $' . lcfirst($this->tabela->getNomeCamelCase()) . '->setId' . $this->tabela->getNomeCamelCase() . '($id);' . PHP_EOL;
        $print .= '        try {' . PHP_EOL;
        $print .= '             if($this->model->delete($' . lcfirst($this->tabela->getNomeCamelCase()) .  ') !== false){' . PHP_EOL;
        $print .= "                  \$this->view->addMensagemSucesso('Dado removido com sucesso!');" . PHP_EOL;
        $print .= '             }else{' . PHP_EOL;
        $print .= '                  $this->view->addMensagemErro($this->model->getErro());' . PHP_EOL;
        $print .= '             }' . PHP_EOL;
        $print .= '        }catch (IOErro $e){ ' . PHP_EOL;
        $print .= "             \$erro  = 'Ocorreu um erro pouco comum. O mesmo será cadastrado no ';" . PHP_EOL;
        $print .= "             \$erro .= 'sistema e solucionado o mais breve possível.';" . PHP_EOL;
        $print .= '             $this->view->addMensagemErro($erro);' . PHP_EOL;
        $print .= '        }' . PHP_EOL;
        $print .= '        $this->manter();' . PHP_EOL;
        $print .= '    }' . PHP_EOL;
        $print .= PHP_EOL;
        return $print;
    }

    private function inserirArquivos()
    {
        $print = '    private function addArquivos(' . $this->tabela->getNomeCamelCase() . ' $obj, $editar = false)' . PHP_EOL . '    {' . PHP_EOL;
        foreach ($this->tabela->getCamposArquivos() as $campo){
            $print .= "        \$arquivo = new ArquivoUpload(\$_FILES['" . $campo->getNome(). "']);" . PHP_EOL;
            $print .= '        return $this->salvarImagem($arquivo, $noticia, $editar);' . PHP_EOL;
        }
        $print .= '    }' . PHP_EOL;

        $print .= '  private function salvarImagem(ArquivoUpload $arquivo,  Noticia $noticia, $editar = false)' . PHP_EOL . '    {' . PHP_EOL;
        $print .= "     \$endLogico = '/media/public/';" . PHP_EOL;
        $print .= "     \$endFisico = ROOT . '../www' . \$endLogico;" . PHP_EOL;


        $print .= '     if (!$editar) {' . PHP_EOL;

        $print .= '         $r = new Redimensionador($arquivo->getArquivo(), $endFisico . $arquivo->nomePorValor(), 450, 450);' . PHP_EOL;
        $print .= "         \$r2 = new Redimensionador(\$arquivo->getArquivo(), \$endFisico . \$arquivo->nomePorValor() . '_mini.jpg', 100, 100);" . PHP_EOL;

        $print .= '         $noticia->setImagem($endLogico . $arquivo->nomePorValor());' . PHP_EOL;
        $print .= '         return $r && $r2;' . PHP_EOL;
        $print .= '     } else {' . PHP_EOL;
        $print .= "         \$end = ROOT . '../www' . \$_POST['foto'];" . PHP_EOL;
        $print .= "         \$miniEnd = str_replace('.jpg', '_mini.jpg', \$end);" . PHP_EOL;

        $print .= "         \$fotoProduto = new ArquivoUpload(\$_FILES['caminhoFotoSubstituir']);" . PHP_EOL;
        $print .= '         if ($fotoProduto->isOk()) {' . PHP_EOL;
        $print .= '             $this->deletarArquivo($end);' . PHP_EOL;
        $print .= '             $this->deletarArquivo($miniEnd);' . PHP_EOL;
        $print .= '             $r = new Redimensionador($fotoProduto->getArquivo(), $end, 450, 450);' . PHP_EOL;
        $print .= '             $r2 = new Redimensionador($fotoProduto->getArquivo(), $miniEnd, 100, 100);' . PHP_EOL;
        $print .= '             return $r && $r2;' . PHP_EOL;
        $print .= '         }' . PHP_EOL;
        $print .= '     }' . PHP_EOL;
        $print .= '     return true;' . PHP_EOL;
        $print .= ' }' . PHP_EOL;
        return $print;
    }

    private function montaEndereco($modulo, $controlador)
    {
        if (!empty($this->config->getUrlAdicional())) {
            $urlAdicional = '/' . $this->config->getUrlAdicional() . '/';
        } else {
            $urlAdicional = '';
        }

        if($this->config->isAdmin()){
            $urlAdicional .= '/admin/';
        }
        $modulo = empty($modulo) ? '' : '/' . $modulo;
        if ($this->config->getRewrite()) {
            return $urlAdicional . lcfirst($modulo) . '/' . lcfirst($controlador) . '/';
        } else {
            return $urlAdicional . '?modulo=' . $modulo . '&exec=' . $controlador . '&acao=';
        }
    }

    private function controladorPai()
    {
        if($this->config->isAdmin()){
            return 'ControladorAdmin';            
        }else if (empty($this->getModulo()) || $this->getModulo() == $this->tabela->getSchema()) {
            return 'ControladorGeral';
        } else {
            return 'Controlador' . ucfirst($this->getModulo());
        }
    }

    private function getPathModulo(){
        if (empty($this->getModulo())) {
            return '';
        } else {
            return  $this->getModulo() . '/';
        }
    }

}
