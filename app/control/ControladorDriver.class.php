<?php

/**
 * Classe controladora referente ao objeto Driver para 
 * a manutenção dos dados no sistema 
 *
 * @package app.control
 * @author Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0 - 28-07-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class ControladorDriver extends ControladorGeral
 {

    /**
     * @var DriverDAO
     */
    protected $model;

     /**
      * Construtor da classe Driver, esse método inicializa o  
      * modelo de dados 
      *
      */
    public function __construct() {
        parent::__construct();
        $this->model = new DriverDAO();
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
        $this->view->setTitle('Driver');

        Componente::carregaComponente('TabelaManterDados'); 
        $tabela = new TabelaManterDados();
        $tabela->setDados(BASE_URL . '/driver/tabela');
        $tabela->setTitulo('Driver');
        $tabela->addAcaoAdicionar(BASE_URL . 
        '/driver/criarNovo');
        $tabela->addAcaoEditar(BASE_URL . 
        '/driver/editar');
        $tabela->addAcaoDeletar(BASE_URL . 
        '/driver/deletarFim');

         //Colunas da tabela
        $tabelaColuna = new TabelaColuna('ID', 'id_driver');
        $tabelaColuna->setLargura(15);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Nome', 'nome');
        $tabelaColuna->setLargura(15);
        $tabelaColuna->setBuscaTipo('character varying');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Velocidade', 'velocidade');
        $tabelaColuna->setLargura(15);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Descrição', 'descricao');
        $tabelaColuna->setLargura(15);
        $tabelaColuna->setBuscaTipo('character varying');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Barramento', 'barramento');
        $tabelaColuna->setLargura(15);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Computador', 'computador');
        $tabelaColuna->setLargura(15);
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
      * @param Driver $obj - Objeto DataTransfer com os dados da classe
      */
    public function criarNovo(Driver $obj = null)
     {
        $driver = $obj == null ? new Driver() : $obj;

        $this->view->setTitle('Novo Driver');

        $this->view->attValue('driver', $driver);

        //Carrega os campos de seleção;
        $this->getSelects();
        $this->view->startForm(BASE_URL  . '/driver/criarNovoFim');
        $this->view->addTemplate('forms/driver');
        $this->view->endForm();
    }

    /**
     * Método edita os dados da tabela ou objeto em questão 
     *
     * @param Driver $obj - Objeto para carregar os formulários 
     */
    public function editar(Driver $obj = null) 
    {
        if($obj == null){
            $id = ValidatorUtil::variavelInt($GLOBALS['ARGS'][0]);
            $driver = $this->model->getById($id);
        }else{
            $driver = $obj;
        }

        $this->view->setTitle('Editar Driver');

        $this->view->attValue('driver', $driver);

        //Carrega os campos de seleção;
        $this->getSelects();

        $this->view->startForm(BASE_URL . '/driver/editarFim');
        $this->view->addTemplate('forms/driver');
        $this->view->endForm();
    }

    /**
     * Método que controla a criação e inserção de um dado no SGBD
     *
     */
    public function criarNovoFim()
     {
        $driver = new Driver();
        try {
            unset($_POST['idDriver']);
            if($driver->setArrayDados($_POST) > 0){ 
                $this->view->addErros($GLOBALS['ERROS']);
            }else{
                if($this->model->create($driver)){
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
        $this->criarNovo($driver);
    }

    /**
     * Método que controla a atualização na tabela 
     *
     */
    public function editarFim()
     {
        $driver = new Driver();
        $id = ValidatorUtil::variavelInt($_POST['idDriver']);
        $driver->setIdDriver($id);
        try {
             if($driver->setArrayDados($_POST) > 0){ 
                 $this->view->addErros($GLOBALS['ERROS']);
             }else{
                 if($this->model->update($driver)){
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
        $this->editar($driver);
    }

    /**
     * Método que controla a exclusão de dados na tabela final
     *
     */
    public function deletarFim()
    {
        $driver = new Driver();
        $id = ValidatorUtil::variavelInt($GLOBALS['ARGS'][0]);
        $driver->setIdDriver($id);
        try {
             if($this->model->delete($driver) !== false){
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
     	//$consulta = $this->model->queryTable('barramento', 'barramento, barramento');
     	//$lista = $this->model->getMapaSimplesDados($consulta, 'barramento', 'barramento');
     	$barramento = new BarramentoDAO();
     	$arr = $barramento->getLista();
     	foreach($arr as $item){
     		$lista[$item->getIdBarramento()] = $item->getNome();
     	}
     	$this->view->attValue('listaBarramento', $lista);
     	
     	//$consulta = $this->model->queryTable('computador', 'computador, computador');
     	//$lista = $this->model->getMapaSimplesDados($consulta, 'computador', 'computador');
     	$pcDAO = new ComputadorDAO();
     	$dados = $pcDAO->getLista();
     	
     	foreach ($dados as $item){
     		$lista[$item->getIdComputador()] = $item->getIdComputador(). ' - '. $item->getNome();
     	}
     	
     	$this->view->attValue('listaComputador', $lista);
     	
    }
    private function addArquivos(Driver $obj, $editar = false)
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
