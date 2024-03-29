<?php

/**
 * Classe controladora referente ao objeto Computador para 
 * a manutenção dos dados no sistema 
 *
 * @package app.control
 * @author Gabriel <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0 - 13-06-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class ControladorComputador extends ControladorGeral
 {

    /**
     * @var ComputadorDAO
     */
    protected $model;

     /**
      * Construtor da classe Computador, esse método inicializa o  
      * modelo de dados 
      *
      */
    public function __construct() {
        parent::__construct();
        $this->model = new ComputadorDAO();
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
        $this->view->setTitle('Computador');

        Componente::carregaComponente('TabelaManterDados'); 
        $tabela = new TabelaManterDados();
        $tabela->setDados(BASE_URL . '/computador/tabela');
        $tabela->setTitulo('Computador');
        $tabela->addAcaoAdicionar(BASE_URL . 
        '/computador/criarNovo');
        $tabela->addAcaoEditar(BASE_URL . 
        '/computador/editar');
        $tabela->addAcaoDeletar(BASE_URL . 
        '/computador/deletarFim');

         //Colunas da tabela
        $tabelaColuna = new TabelaColuna('ID', 'id_computador');
        $tabelaColuna->setLargura(33);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Nome', 'nome');
        $tabelaColuna->setLargura(33);
        $tabelaColuna->setBuscaTipo('character varying');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Descrição', 'descricao');
        $tabelaColuna->setLargura(33);
        $tabelaColuna->setBuscaTipo('character varying');
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
      * @param Computador $obj - Objeto DataTransfer com os dados da classe
      */
    public function criarNovo(Computador $obj = null)
     {
        $computador = $obj == null ? new Computador() : $obj;

        $this->view->setTitle('Novo Computador');

        $this->view->attValue('computador', $computador);

        //Carrega os campos de seleção;
        $this->view->attValue('placaMae', new PlacaMae());
        $this->view->attValue('processador', new Processador());
        $this->view->attValue('listaMemoria', array(new Memoria()));
        $this->view->attValue('listaDisco', array(new DiscoRigido()));
        $this->view->attValue('fonte', new Fonte());
        $this->view->attValue('placaVideo', new PlacaVideo());
        $this->view->attValue('driver', new Driver());
        
        $this->view->attValue('exibirPM', 'none');
        $this->view->attValue('exibirF', 'none');
        $this->view->attValue('exibirDR', 'none');
        $this->view->attValue('exibirP', 'none');
        $this->view->attValue('exibirM', 'none');
        $this->view->attValue('exibirD', 'none');
        $this->view->attValue('exibirPV', 'none');
        $this->getSelects();
        $this->view->startForm(BASE_URL  . '/computador/criarNovoFim');
        $this->view->addTemplate('forms/computador');
        $this->view->endForm();
    }

    /**
     * Método edita os dados da tabela ou objeto em questão 
     *
     * @param Computador $obj - Objeto para carregar os formulários 
     */
    public function editar(Computador $obj = null) 
    {
       
        if($obj == null){
            $id = ValidatorUtil::variavelInt($GLOBALS['ARGS'][0]);
            $computador = $this->model->getById($id);
        }else{
            $computador = $obj;
        }

        $this->view->setTitle('Editar Computador');

        $this->view->attValue('computador', $computador);

        //Carrega os campos de seleção;
        $this->getSelects();

        $this->view->startForm(BASE_URL . '/computador/editarFim');
        
        $placaMaeDAO = new PlacaMaeDAO();
        $placaMae = $placaMaeDAO->getByComputerID($computador->getID());
        if($placaMae->getNome() == '')
        	$this->view->attValue('exibirPM', 'none');
       	else
       		$this->view->attValue('exibirPM', 'block');
        $this->view->attValue('placaMae', $placaMae);
        		
        $processadorDAO = new ProcessadorDAO();
        $processador = $processadorDAO->getByComputerID($computador->getID());
        if($processador->getNome() == '')
        	$this->view->attValue('exibirP', 'none');
        else
        	$this->view->attValue('exibirP', 'block');
        $this->view->attValue('processador', $processador);
        	
        
        $memoriaDAO = new MemoriaDAO();
        
        $listaMemoriaController = $memoriaDAO->getLista('computador = ' .$computador->getID().'--');
        
        $listaMemoria = [];
        $memoria = $memoriaDAO->getByComputerID($computador->getID());
        foreach($listaMemoriaController as $memoria){
        
        if($memoria->getNome() == '')
        	$this->view->attValue('exibirM', 'none');
        else 
        	$this->view->attValue('exibirM', 'block');
                $listaMemoria[] = $memoria;

        }
        $this->view->attValue('listaMemoria', $listaMemoria);
        
        
        $discoRigidoDAO = new DiscoRigidoDAO();

        $listaDiscoController = $discoRigidoDAO->getLista('computador = ' .$computador->getIdComputador().'--');
        
    
        $listaDisco = [];
        foreach($listaDiscoController as $discoRigido){
        if($discoRigido->getNome() == '')
        	$this->view->attValue('exibirDR', 'none');
       	else
       		$this->view->attValue('exibirDR', 'block');
        $listaDisco[] = $discoRigido;
   
        }
         $this->view->attValue('listaDisco', $listaDisco);
        
        $fonteDAO = new FonteDAO();
        $fonte = $fonteDAO->getByComputerID($computador->getID());
        if($fonte->getNome() == '')
        	$this->view->attValue('exibirF', 'none');
        else
        	$this->view->attValue('exibirF', 'block');
        $this->view->attValue('fonte', $fonte);
        
        
        $placaVideoDAO = new PlacaVideoDAO();
        $placaVideo = $placaVideoDAO->getByComputerID($computador->getID());
        if($placaVideo->getNome()=='')
        	$this->view->attValue('exibirPV', 'none');
        else 
        	$this->view->attValue('exibirPV', 'block');
        $this->view->attValue('placaVideo', $placaVideo);
        
        
        $driverDAO = new DriverDAO();
        $driver = $driverDAO->getByComputerID($computador->getID());
        if($driver->getNome()=='')
        	$this->view->attValue('exibirD', 'none');
        else
        	$this->view->attValue('exibirD', 'block');
        $this->view->attValue('driver', $driver);
        
        
        //ds($placaMae);
        $this->view->addTemplate('forms/computador');
        $this->view->endForm();
    }

    /**
     * Método que controla a criação e inserção de um dado no SGBD
     *
     */
    public function criarNovoFim()
     {
        $computador = new Computador();
        try {
            unset($_POST['idComputador']);
            if($computador->setArrayDados($_POST) > 0){ 
                $this->view->addErros($GLOBALS['ERROS']);
            }else{
                if($this->model->create($computador)){
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
        $this->criarNovo($computador);
    }

    /**
     * Método que controla a atualização na tabela 
     *
     */
    public function editarFim()
     {
        $computador = new Computador();
        $id = ValidatorUtil::variavelInt($_POST['idComputador']);
        $computador->setIdComputador($id);
        try {
             if($computador->setArrayDados($_POST) > 0){ 
                 $this->view->addErros($GLOBALS['ERROS']);
             }else{
                 if($this->model->update($computador)){
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
        $this->editar($computador);
    }

    /**
     * Método que controla a exclusão de dados na tabela final
     *
     */
    public function deletarFim()
    {
        
             
        $computador = new Computador();
        $id = ValidatorUtil::variavelInt($GLOBALS['ARGS'][0]);
        $computador->setIdComputador($id);
        try {
             if($this->model->delete($computador) !== false){
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
    }
    private function addArquivos(Computador $obj, $editar = false)
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
