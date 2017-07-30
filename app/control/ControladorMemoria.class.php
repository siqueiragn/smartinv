<?php

/**
 * Classe controladora referente ao objeto Memoria para 
 * a manutenção dos dados no sistema 
 *
 * @package app.control
 * @author Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0 - 28-07-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class ControladorMemoria extends ControladorGeral
 {

    /**
     * @var MemoriaDAO
     */
    protected $model;

     /**
      * Construtor da classe Memoria, esse método inicializa o  
      * modelo de dados 
      *
      */
    public function __construct() {
        parent::__construct();
        $this->model = new MemoriaDAO();
    }

     /**
      * Método que redireciona para a página de manter dados  
      *
      */
    public function index()
    {
        $this->manter();
    }

     /**
      * Método que cria a tabela que serve de visualização para os dados.  
      * através dessa página pode se acessar as demans funcionalidades do CRUD.  
      *
      */
    public function manter()
    {
        $this->view->setTitle('Memoria');

        Componente::carregaComponente('TabelaManterDados'); 
        $tabela = new TabelaManterDados();
        $tabela->setDados(BASE_URL . '/memoria/tabela');
        $tabela->setTitulo('Memoria');
        $tabela->addAcaoAdicionar(BASE_URL . 
        '/memoria/criarNovo');
        $tabela->addAcaoEditar(BASE_URL . 
        '/memoria/editar');
        $tabela->addAcaoDeletar(BASE_URL . 
        '/memoria/deletarFim');

         //Colunas da tabela
        $tabelaColuna = new TabelaColuna('ID', 'id_memoria');
        $tabelaColuna->setLargura(12);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Nome', 'nome');
        $tabelaColuna->setLargura(12);
        $tabelaColuna->setBuscaTipo('character varying');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Frequencia', 'frequencia');
        $tabelaColuna->setLargura(12);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Capacidade', 'capacidade');
        $tabelaColuna->setLargura(12);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Tipo', 'tipo');
        $tabelaColuna->setLargura(12);
        $tabelaColuna->setBuscaTipo('character varying');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Descrição', 'descricao');
        $tabelaColuna->setLargura(12);
        $tabelaColuna->setBuscaTipo('character varying');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Computador', 'computador');
        $tabelaColuna->setLargura(12);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $this->view->addComponente($tabela);
    }

     /**
      * Método que gera os dados json da tabela de manutenção dos dados 
      * e recebe os dados de consulta para a sua atualizacao 
      *
      */
    public function tabela()
     {
        $this->view->setRenderizado();
        Componente::carregaComponente('TabelaConsulta');
        $tabela = new TabelaConsulta(ValidatorUtil::variavel($_POST['sidx']));
        $tabela->recebeDados($_POST);

        $dados = $this->model->getTabela($tabela);

        echo json_encode($dados);
    }


     /**
      * Método que controla a inserção de um novo dado
      *
      * @param Memoria $obj - Objeto DataTransfer com os dados da classe
      */
    public function criarNovo(Memoria $obj = null)
     {
        $memoria = $obj == null ? new Memoria() : $obj;

        $this->view->setTitle('Novo Memoria');

        $this->view->attValue('memoria', $memoria);

        //Carrega os campos de seleção;
        $this->getSelects();
        $this->view->startForm(BASE_URL  . '/memoria/criarNovoFim');
        $this->view->addTemplate('forms/memoria');
        $this->view->endForm();
    }

    /**
     * Método edita os dados da tabela ou objeto em questão 
     *
     * @param Memoria $obj - Objeto para carregar os formulários 
     */
    public function editar(Memoria $obj = null) 
    {
        if($obj == null){
            $id = ValidatorUtil::variavelInt($GLOBALS['ARGS'][0]);
            $memoria = $this->model->getById($id);
        }else{
            $memoria = $obj;
        }

        $this->view->setTitle('Editar Memoria');

        $this->view->attValue('memoria', $memoria);

        //Carrega os campos de seleção;
        $this->getSelects();

        $this->view->startForm(BASE_URL . '/memoria/editarFim');
        $this->view->addTemplate('forms/memoria');
        $this->view->endForm();
    }

    /**
     * Método que controla a criação e inserção de um dado no SGBD
     *
     */
    public function criarNovoFim()
     {
        $memoria = new Memoria();
        try {
            unset($_POST['idMemoria']);
            if($memoria->setArrayDados($_POST) > 0){ 
                $this->view->addErros($GLOBALS['ERROS']);
            }else{
                if($this->model->create($memoria)){
                    $this->view->addMensagemSucesso('Dados inseridos com sucesso!');
                    $this->manter();
                    return ;
                }else{
                    $this->view->addMensagemErro('Erro ao inserir seus dados tente novamente mais tarde.');
                }
            }
        }catch (IOErro $e){ 
             $erro  = 'Ocorreu um erro pouco comum. O mesmo será cadastrado no ';
             $erro .= 'sistema e solucionado o mais breve possível.';
             $this->view->addMensagemErro($erro);
        }
        $this->criarNovo($memoria);
    }

    /**
     * Método que controla a atualização na tabela 
     *
     */
    public function editarFim()
     {
        $memoria = new Memoria();
        $id = ValidatorUtil::variavelInt($_POST['idMemoria']);
        $memoria->setIdMemoria($id);
        try {
             if($memoria->setArrayDados($_POST) > 0){ 
                 $this->view->addErros($GLOBALS['ERROS']);
             }else{
                 if($this->model->update($memoria)){
                     $this->view->addMensagemSucesso('Dados alterados com sucesso!');
                     $this->manter();
                     return ;
                 }else{
                     $this->view->addMensagemErro($this->model->getErros());
                 }
             }
        }catch (IOErro $e){ 
             $erro  = 'Ocorreu um erro pouco comum. O mesmo será cadastrado no ';
             $erro .= 'sistema e solucionado o mais breve possível.';
             $this->view->addMensagemErro($erro);
        }
        $this->editar($memoria);
    }

    /**
     * Método que controla a exclusão de dados na tabela final
     *
     */
    public function deletarFim()
    {
        $memoria = new Memoria();
        $id = ValidatorUtil::variavelInt($GLOBALS['ARGS'][0]);
        $memoria->setIdMemoria($id);
        try {
             if($this->model->delete($memoria) !== false){
                  $this->view->addMensagemSucesso('Dado removido com sucesso!');
             }else{
                  $this->view->addMensagemErro($this->model->getErro());
             }
        }catch (IOErro $e){ 
             $erro  = 'Ocorreu um erro pouco comum. O mesmo será cadastrado no ';
             $erro .= 'sistema e solucionado o mais breve possível.';
             $this->view->addMensagemErro($erro);
        }
        $this->manter();
    }

    /**
     * Método que cria os select 
     *
     */
    private function getSelects()
     {
     	//$consulta = $this->model->queryTable('computador', 'computador, computador');
     	//$lista = $this->model->getMapaSimplesDados($consulta, 'computador', 'computador');
     	$pcDAO = new ComputadorDAO();
     	$dados = $pcDAO->getLista();
     	
     	foreach ($dados as $item){
     		$lista[$item->getIdComputador()] = $item->getIdComputador(). ' - '. $item->getNome();
     	}
     	
     	$this->view->attValue('listaComputador', $lista);
     	
    }
    private function addArquivos(Memoria $obj, $editar = false)
    {
    }
  private function salvarImagem(ArquivoUpload $arquivo,  Noticia $noticia, $editar = false)
    {
     $endLogico = '/media/public/';
     $endFisico = ROOT . '../www' . $endLogico;
     if (!$editar) {
         $r = new Redimensionador($arquivo->getArquivo(), $endFisico . $arquivo->nomePorValor(), 450, 450);
         $r2 = new Redimensionador($arquivo->getArquivo(), $endFisico . $arquivo->nomePorValor() . '_mini.jpg', 100, 100);
         $noticia->setImagem($endLogico . $arquivo->nomePorValor());
         return $r && $r2;
     } else {
         $end = ROOT . '../www' . $_POST['foto'];
         $miniEnd = str_replace('.jpg', '_mini.jpg', $end);
         $fotoProduto = new ArquivoUpload($_FILES['caminhoFotoSubstituir']);
         if ($fotoProduto->isOk()) {
             $this->deletarArquivo($end);
             $this->deletarArquivo($miniEnd);
             $r = new Redimensionador($fotoProduto->getArquivo(), $end, 450, 450);
             $r2 = new Redimensionador($fotoProduto->getArquivo(), $miniEnd, 100, 100);
             return $r && $r2;
         }
     }
     return true;
 }
}
