<?php

/**
 * Classe controladora referente ao objeto Barramento_placamae para 
 * a manutenção dos dados no sistema 
 *
 * @package app.control
 * @author Gabriel <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0 - 13-06-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class ControladorBarramentoPlacamae extends ControladorGeral
 {

    /**
     * @var BarramentoPlacamaeDAO
     */
    protected $model;

     /**
      * Construtor da classe Barramento_placamae, esse método inicializa o  
      * modelo de dados 
      *
      */
    public function __construct() {
        parent::__construct();
        $this->model = new BarramentoPlacamaeDAO();
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
        $this->view->setTitle('Barramento placamae');

        Componente::carregaComponente('TabelaManterDados'); 
        $tabela = new TabelaManterDados();
        $tabela->setDados(BASE_URL . '/barramentoPlacamae/tabela');
        $tabela->setTitulo('Barramento placamae');
        $tabela->addAcaoAdicionar(BASE_URL . 
        '/barramentoPlacamae/criarNovo');
        $tabela->addAcaoEditar(BASE_URL . 
        '/barramentoPlacamae/editar');
        $tabela->addAcaoDeletar(BASE_URL . 
        '/barramentoPlacamae/deletarFim');

         //Colunas da tabela
        $tabelaColuna = new TabelaColuna('Id barramento placamae', 'id_barramento_placamae');
        $tabelaColuna->setLargura(40);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Id barramento', 'id_barramento');
        $tabelaColuna->setLargura(40);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Id placa mae', 'id_placa_mae');
        $tabelaColuna->setLargura(40);
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
      * @param BarramentoPlacamae $obj - Objeto DataTransfer com os dados da classe
      */
    public function criarNovo(BarramentoPlacamae $obj = null)
     {
        $barramentoPlacamae = $obj == null ? new BarramentoPlacamae() : $obj;

        $this->view->setTitle('Novo Barramento placamae');

        $this->view->attValue('barramentoPlacamae', $barramentoPlacamae);

        //Carrega os campos de seleção;
        $this->getSelects();
        $this->view->startForm(BASE_URL  . '/barramentoPlacamae/criarNovoFim');
        $this->view->addTemplate('forms/barramento_placamae');
        $this->view->endForm();
    }

    /**
     * Método edita os dados da tabela ou objeto em questão 
     *
     * @param BarramentoPlacamae $obj - Objeto para carregar os formulários 
     */
    public function editar(BarramentoPlacamae $obj = null) 
    {
        if($obj == null){
            $id = ValidatorUtil::variavelInt($GLOBALS['ARGS'][0]);
            $barramentoPlacamae = $this->model->getById($id);
        }else{
            $barramentoPlacamae = $obj;
        }

        $this->view->setTitle('Editar Barramento placamae');

        $this->view->attValue('barramentoPlacamae', $barramentoPlacamae);

        //Carrega os campos de seleção;
        $this->getSelects();

        $this->view->startForm(BASE_URL . '/barramentoPlacamae/editarFim');
        $this->view->addTemplate('forms/barramento_placamae');
        $this->view->endForm();
    }

    /**
     * Método que controla a criação e inserção de um dado no SGBD
     *
     */
    public function criarNovoFim()
     {
        $barramentoPlacamae = new BarramentoPlacamae();
        try {
            unset($_POST['idBarramentoPlacamae']);
            if($barramentoPlacamae->setArrayDados($_POST) > 0){ 
                $this->view->addErros($GLOBALS['ERROS']);
            }else{
                if($this->model->create($barramentoPlacamae)){
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
        $this->criarNovo($barramentoPlacamae);
    }

    /**
     * Método que controla a atualização na tabela 
     *
     */
    public function editarFim()
     {
        $barramentoPlacamae = new BarramentoPlacamae();
        $id = ValidatorUtil::variavelInt($_POST['idBarramentoPlacamae']);
        $barramentoPlacamae->setIdBarramentoPlacamae($id);
        try {
             if($barramentoPlacamae->setArrayDados($_POST) > 0){ 
                 $this->view->addErros($GLOBALS['ERROS']);
             }else{
                 if($this->model->update($barramentoPlacamae)){
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
        $this->editar($barramentoPlacamae);
    }

    /**
     * Método que controla a exclusão de dados na tabela final
     *
     */
    public function deletarFim()
    {
        $barramentoPlacamae = new BarramentoPlacamae();
        $id = ValidatorUtil::variavelInt($GLOBALS['ARGS'][0]);
        $barramentoPlacamae->setIdBarramentoPlacamae($id);
        try {
             if($this->model->delete($barramentoPlacamae) !== false){
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
        $consulta = $this->model->queryTable('barramento', 'id_barramento, barramento');
        $lista = $this->model->getMapaSimplesDados($consulta, 'id_barramento', 'barramento');
        $this->view->attValue('listaBarramento', $lista);

        $consulta = $this->model->queryTable('placa_mae', 'id_placa_mae, placa_mae');
        $lista = $this->model->getMapaSimplesDados($consulta, 'id_placa_mae', 'placa_mae');
        $this->view->attValue('listaPlacaMae', $lista);

    }
    private function addArquivos(BarramentoPlacamae $obj, $editar = false)
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
