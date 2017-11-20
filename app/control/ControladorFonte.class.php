<?php

/**
 * Classe controladora referente ao objeto Fonte para 
 * a manutenção dos dados no sistema 
 *
 * @package app.control
 * @author Gabriel <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0 - 13-06-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class ControladorFonte extends ControladorGeral
 {

    /**
     * @var FonteDAO
     */
    protected $model;

     /**
      * Construtor da classe Fonte, esse método inicializa o  
      * modelo de dados 
      *
      */
    public function __construct() {
        parent::__construct();
        $this->model = new FonteDAO();
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
        $this->view->setTitle('Fonte');

        Componente::carregaComponente('TabelaManterDados'); 
        $tabela = new TabelaManterDados();
        $tabela->setDados(BASE_URL . '/fonte/tabela');
        $tabela->setTitulo('Fonte');
        $tabela->addAcaoAdicionar(BASE_URL . 
        '/fonte/criarNovo');
        $tabela->addAcaoEditar(BASE_URL . 
        '/fonte/editar');
        $tabela->addAcaoDeletar(BASE_URL . 
        '/fonte/deletarFim');

         //Colunas da tabela
        $tabelaColuna = new TabelaColuna('ID', 'id_fonte');
        $tabelaColuna->setLargura(20);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Nome', 'nome');
        $tabelaColuna->setLargura(20);
        $tabelaColuna->setBuscaTipo('character varying');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Potência', 'potencia');
        $tabelaColuna->setLargura(20);
        $tabelaColuna->setBuscaTipo('integer');
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
      * @param Fonte $obj - Objeto DataTransfer com os dados da classe
      */
    public function criarNovo(Fonte $obj = null)
     {
        $fonte = $obj == null ? new Fonte() : $obj;

        $this->view->setTitle('Novo Fonte');

        $this->view->attValue('fonte', $fonte);

        //Carrega os campos de seleção;
        $this->getSelects();
        $this->view->startForm(BASE_URL  . '/fonte/criarNovoFim');
        $this->view->addTemplate('forms/fonte');
        $this->view->endForm();
    }

    /**
     * Método edita os dados da tabela ou objeto em questão 
     *
     * @param Fonte $obj - Objeto para carregar os formulários 
     */
    public function editar(Fonte $obj = null) 
    {
        if($obj == null){
            $id = ValidatorUtil::variavelInt($GLOBALS['ARGS'][0]);
            $fonte = $this->model->getById($id);
        }else{
            $fonte = $obj;
        }

        $this->view->setTitle('Editar Fonte');

        $this->view->attValue('fonte', $fonte);

        //Carrega os campos de seleção;
        $this->getSelects();

        $this->view->startForm(BASE_URL . '/fonte/editarFim');
        $this->view->addTemplate('forms/fonte');
        $this->view->endForm();
    }

    /**
     * Método que controla a criação e inserção de um dado no SGBD
     *
     */
    public function criarNovoFim()
     {
        $fonte = new Fonte();
        try {
            unset($_POST['idFonte']);
            if($fonte->setArrayDados($_POST) > 0){ 
                $this->view->addErros($GLOBALS['ERROS']);
            }else{
                if($this->model->create($fonte)){
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
        $this->criarNovo($fonte);
    }

    /**
     * Método que controla a atualização na tabela 
     *
     */
    public function editarFim()
     {
        $fonte = new Fonte();
        $id = ValidatorUtil::variavelInt($_POST['idFonte']);
        $fonte->setIdFonte($id);
        try {
             if($fonte->setArrayDados($_POST) > 0){ 
                 $this->view->addErros($GLOBALS['ERROS']);
             }else{
                 if($this->model->update($fonte)){
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
        $this->editar($fonte);
    }

    /**
     * Método que controla a exclusão de dados na tabela final
     *
     */
    public function deletarFim()
    {
        $fonte = new Fonte();
        $id = ValidatorUtil::variavelInt($GLOBALS['ARGS'][0]);
        $fonte->setIdFonte($id);
        try {
             if($this->model->delete($fonte) !== false){
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
     	$pcDAO = new ComputadorDAO();
     	$dados = $pcDAO->getLista();
     	$lista[0] = '';
     	foreach ($dados as $item){
     		$lista[$item->getIdComputador()] = $item->getIdComputador(). ' - '. $item->getNome();
     	}
        $this->view->attValue('listaComputador', $lista);

    }
    private function addArquivos(Fonte $obj, $editar = false)
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
