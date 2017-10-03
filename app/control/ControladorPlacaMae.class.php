<?php

/**
 * Classe controladora referente ao objeto Placa_mae para 
 * a manutenção dos dados no sistema 
 *
 * @package app.control
 * @author Gabriel <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0 - 30-07-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class ControladorPlacaMae extends ControladorGeral
 {

    /**
     * @var PlacaMaeDAO
     */
    protected $model;

     /**
      * Construtor da classe Placa_mae, esse método inicializa o  
      * modelo de dados 
      *
      */
    public function __construct() {
        parent::__construct();
        $this->model = new PlacaMaeDAO();
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
        $this->view->setTitle('Placa Mãe');

        Componente::carregaComponente('TabelaManterDados'); 
        $tabela = new TabelaManterDados();
        $tabela->setDados(BASE_URL . '/placaMae/tabela');
        $tabela->setTitulo('Placa Mãe');
        $tabela->addAcaoAdicionar(BASE_URL . 
        '/placaMae/criarNovo');
        $tabela->addAcaoEditar(BASE_URL . 
        '/placaMae/editar');
        $tabela->addAcaoDeletar(BASE_URL . 
        '/placaMae/deletarFim');

         //Colunas da tabela
        $tabelaColuna = new TabelaColuna('ID', 'id_placa_mae');
        $tabelaColuna->setLargura(20);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Nome', 'nome');
        $tabelaColuna->setLargura(20);
        $tabelaColuna->setBuscaTipo('character varying');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Socket', 'socket');
        $tabelaColuna->setLargura(20);
        $tabelaColuna->setBuscaTipo('character varying');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Descrição', 'descricao');
        $tabelaColuna->setLargura(20);
        $tabelaColuna->setBuscaTipo('character varying');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Computador', 'computador');
        $tabelaColuna->setLargura(20);
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
      * @param PlacaMae $obj - Objeto DataTransfer com os dados da classe
      */
    public function criarNovo(PlacaMae $obj = null)
     {
        $placaMae = $obj == null ? new PlacaMae() : $obj;

        $this->view->setTitle('Nova Placa Mãe');

        $this->view->attValue('placaMae', $placaMae);

        //Carrega os campos de seleção;
        $this->getSelects();
        $this->view->startForm(BASE_URL  . '/placaMae/criarNovoFim');
        $this->view->addTemplate('forms/placa_maeNew');
        $this->view->endForm();
    }

    /**
     * Método edita os dados da tabela ou objeto em questão 
     *
     * @param PlacaMae $obj - Objeto para carregar os formulários 
     */
    public function editar(PlacaMae $obj = null) 
    {
        if($obj == null){
            $id = ValidatorUtil::variavelInt($GLOBALS['ARGS'][0]);
            $placaMae = $this->model->getById($id);
        }else{
            $placaMae = $obj;
        }

        $this->view->setTitle('Editar Placa Mãe');

        $this->view->attValue('placaMae', $placaMae);

        //Carrega os campos de seleção;
        $this->getSelects();

        $this->view->startForm(BASE_URL . '/placaMae/editarFim');
        $this->view->addTemplate('forms/placa_mae');
        $this->view->endForm();
    }

    /**
     * Método que controla a criação e inserção de um dado no SGBD
     *
     */
    public function criarNovoFim()
     {
        $placaMae = new PlacaMae();
        try {
            unset($_POST['idPlacaMae']);
            if($placaMae->setArrayDados($_POST) > 0){ 
                $this->view->addErros($GLOBALS['ERROS']);
            }else{
                if($this->model->create($placaMae)){
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
        $this->criarNovo($placaMae);
    }

    /**
     * Método que controla a atualização na tabela 
     *
     */
    public function editarFim()
     {
        $placaMae = new PlacaMae();
        $id = ValidatorUtil::variavelInt($_POST['idPlacaMae']);
        $placaMae->setIdPlacaMae($id);
        try {
             if($placaMae->setArrayDados($_POST) > 0){ 
                 $this->view->addErros($GLOBALS['ERROS']);
				 
             }else{
			 if($_POST['computador'] == null){
					 echo "A";
				 
				 $placaMae->setComputador(null);
				 echo $placaMae->getComputador();
				
				
			 }
                 if($this->model->update($placaMae)){
                     $this->view->addMensagemSucesso('Dados alterados com sucesso!');
                     $this->manter();
					
                     return true;
                 }else{
					
                     $this->view->addMensagemErro($this->model->getErro());
					
                 }
             }
        }catch (IOErro $e){ 
             $erro  = 'Ocorreu um erro pouco comum. O mesmo será cadastrado no ';
             $erro .= 'sistema e solucionado o mais breve possível.';
             $this->view->addMensagemErro($erro);
        }
        $this->editar($placaMae);
    }

    /**
     * Método que controla a exclusão de dados na tabela final
     *
     */
    public function deletarFim()
    {
        $placaMae = new PlacaMae();
        $id = ValidatorUtil::variavelInt($GLOBALS['ARGS'][0]);
        $placaMae->setIdPlacaMae($id);
        try {
             if($this->model->delete($placaMae) !== false){
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
    	$lista = [];
		$lista2 = [];
		$lista3 = [];

     	$id = ValidatorUtil::variavelInt($GLOBALS['ARGS'][0]);
		
     	$placaMae = $this->model->getById($id);
     	
     	$pcDAO = new ComputadorDAO();
     	$dados = $pcDAO->getLista();
     	$lista3[''] = '';
     	foreach ($dados as $item){
     		$lista3[$item->getIdComputador()] = $item->getIdComputador(). ' - '. $item->getNome();
     	}
     	$this->view->attValue('listaComputador', $lista3);
		
     	$barramentoDAO = new BarramentoDAO();
     	$dados = $barramentoDAO->getLista();
     	
     	foreach ($dados as $item){
     		$lista[$item->getIdBarramento()] = $item->getNome();
     	}
     	$this->view->attValue('lista',$lista);
     
     	$barramentoMoboDAO = new BarramentoPlacamaeDAO();
     	$dados = $barramentoMoboDAO->getLista('id_placa_mae = '.$placaMae->getIdPlacaMae());
     	
		foreach ($dados as $item){
     		$lista2[$item->getIdBarramentoPlacaMae()] = $barramentoDAO->getByID($item->getIdBarramento())->getNome();
     	}
     	
     	$this->view->attValue('listaInt',$lista2);
    
    }
    private function addArquivos(PlacaMae $obj, $editar = false)
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
