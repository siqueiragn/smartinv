<?php

/**
 * Classe controladora referente ao objeto Algoritmo para 
 * a manutenção dos dados no sistema 
 *
 * @package app.control
 * @author Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0 - 09-10-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class ControladorAlgoritmo extends ControladorGeral
 {

    /**
     * @var AlgoritmoDAO
     */
    protected $model;

     /**
      * Construtor da classe Algoritmo, esse método inicializa o  
      * modelo de dados 
      *
      */
    public function __construct() {
        parent::__construct();
        $this->model = new AlgoritmoDAO();
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
        $this->view->setTitle('Algoritmo');

        Componente::carregaComponente('TabelaManterDados'); 
        $tabela = new TabelaManterDados();
        $tabela->setDados(BASE_URL . '/algoritmo/tabela');
        $tabela->setTitulo('Algoritmo');
        $tabela->addAcaoAdicionar(BASE_URL . 
        '/algoritmo/criarNovo');
        $tabela->addAcaoEditar(BASE_URL . 
        '/algoritmo/editar');
        $tabela->addAcaoDeletar(BASE_URL . 
        '/algoritmo/deletarFim');

         //Colunas da tabela
        $tabelaColuna = new TabelaColuna('ID Configuração', 'id_algoritmo');
        $tabelaColuna->setLargura(14);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('ID Placa Mãe', 'id_placa_mae');
        $tabelaColuna->setLargura(14);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('ID Processador', 'id_processador');
        $tabelaColuna->setLargura(14);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('ID Fonte', 'id_fonte');
        $tabelaColuna->setLargura(14);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('ID Memoria', 'id_memoria');
        $tabelaColuna->setLargura(14);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('ID Disco Rígido', 'id_disco_rigido');
        $tabelaColuna->setLargura(14);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Computador', 'id_computador');
        $tabelaColuna->setLargura(14);
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
      * @param Algoritmo $obj - Objeto DataTransfer com os dados da classe
      */
    public function criarNovo(Algoritmo $obj = null)
     {
        /*$algoritmo = $obj == null ? new Algoritmo() : $obj;

        $this->view->setTitle('Novo Algoritmo');

        $this->view->attValue('algoritmo', $algoritmo);

        //Carrega os campos de seleção;
        $this->getSelects();
        $this->view->startForm(BASE_URL  . '/algoritmo/criarNovoFim');
        $this->view->addTemplate('forms/algoritmo');
        $this->view->endForm();*/
    }

    /**
     * Método edita os dados da tabela ou objeto em questão 
     *
     * @param Algoritmo $obj - Objeto para carregar os formulários 
     */
    public function editar(Algoritmo $obj = null) 
    {
        if($obj == null){
            $id = ValidatorUtil::variavelInt($GLOBALS['ARGS'][0]);
            $algoritmo = $this->model->getById($id);
        }else{
            $algoritmo = $obj;
        }

        $this->view->setTitle('Editar Algoritmo');

        $this->view->attValue('algoritmo', $algoritmo);

        //Carrega os campos de seleção;
        $this->getSelects();

        $this->view->startForm(BASE_URL . '/algoritmo/editarFim');
        $this->view->addTemplate('forms/algoritmo');
        $this->view->endForm();
    }

    /**
     * Método que controla a criação e inserção de um dado no SGBD
     *
     */
    public function criarNovoFim()
     {
        $algoritmo = new Algoritmo();
        try {
            unset($_POST['idAlgoritmo']);
            if($algoritmo->setArrayDados($_POST) > 0){ 
                $this->view->addErros($GLOBALS['ERROS']);
            }else{
                if($this->model->create($algoritmo)){
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
        $this->criarNovo($algoritmo);
    }

    /**
     * Método que controla a atualização na tabela 
     *
     */
    public function editarFim()
     {
        $algoritmo = new Algoritmo();
        $id = ValidatorUtil::variavelInt($_POST['idAlgoritmo']);
        $algoritmo->setIdAlgoritmo($id);
        try {
             if($algoritmo->setArrayDados($_POST) > 0){ 
                 $this->view->addErros($GLOBALS['ERROS']);
             }else{
                 if($this->model->update($algoritmo)){
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
        $this->editar($algoritmo);
    }

    /**
     * Método que controla a exclusão de dados na tabela final
     *
     */
    public function deletarFim()
    {
        $algoritmo = new Algoritmo();
        $id = ValidatorUtil::variavelInt($GLOBALS['ARGS'][0]);
        $algoritmo->setIdAlgoritmo($id);
        try {
             if($this->model->delete($algoritmo) !== false){
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
    private function addArquivos(Algoritmo $obj, $editar = false)
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
