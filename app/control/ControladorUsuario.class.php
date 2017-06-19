<?php

/**
 * Classe controladora referente ao objeto Usuario para 
 * a manutenção dos dados no sistema 
 *
 * @package app.control
 * @author Gabriel <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0 - 13-06-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class ControladorUsuario extends ControladorGeral
 {

    /**
     * @var UsuarioDAO
     */
    protected $model;

     /**
      * Construtor da classe Usuario, esse método inicializa o  
      * modelo de dados 
      *
      */
    public function __construct() {
        parent::__construct();
        $this->model = new UsuarioDAO();
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
        $this->view->setTitle('Usuário');

        Componente::carregaComponente('TabelaManterDados'); 
        $tabela = new TabelaManterDados();
        $tabela->setDados(BASE_URL . '/usuario/tabela');
        $tabela->setTitulo('Usuário');
        $tabela->addAcaoAdicionar(BASE_URL . 
        '/usuario/criarNovo');
        $tabela->addAcaoEditar(BASE_URL . 
        '/usuario/editar');
        $tabela->addAcaoDeletar(BASE_URL . 
        '/usuario/deletarFim');

         //Colunas da tabela
        $tabelaColuna = new TabelaColuna('Id usuário', 'id_usuario');
        $tabelaColuna->setLargura(40);
        $tabelaColuna->setBuscaTipo('integer');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Login', 'login');
        $tabelaColuna->setLargura(60);
        $tabelaColuna->setBuscaTipo('character varying');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Password', 'password');
        $tabelaColuna->setLargura(60);
        $tabelaColuna->setBuscaTipo('character varying');
        $tabela->addColuna($tabelaColuna);

        $tabelaColuna = new TabelaColuna('Email', 'email');
        $tabelaColuna->setLargura(60);
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
      * @param Usuario $obj - Objeto DataTransfer com os dados da classe
      */
    public function criarNovo(Usuario $obj = null)
     {
        $usuario = $obj == null ? new Usuario() : $obj;

        $this->view->setTitle('Novo Usuário');

        $this->view->attValue('usuario', $usuario);

        //Carrega os campos de seleção;
        $this->getSelects();
        $this->view->startForm(BASE_URL  . '/usuario/criarNovoFim');
        $this->view->addTemplate('forms/usuario');
        $this->view->endForm();
    }

    /**
     * Método edita os dados da tabela ou objeto em questão 
     *
     * @param Usuario $obj - Objeto para carregar os formulários 
     */
    public function editar(Usuario $obj = null) 
    {
        if($obj == null){
            $id = ValidatorUtil::variavelInt($GLOBALS['ARGS'][0]);
            $usuario = $this->model->getById($id);
        }else{
            $usuario = $obj;
        }

        $this->view->setTitle('Editar Usuário');

        $this->view->attValue('usuario', $usuario);

        //Carrega os campos de seleção;
        $this->getSelects();

        $this->view->startForm(BASE_URL . '/usuario/editarFim');
        $this->view->addTemplate('forms/usuario');
        $this->view->endForm();
    }

    /**
     * Método que controla a criação e inserção de um dado no SGBD
     *
     */
    public function criarNovoFim()
     {
        $usuario = new Usuario();
        try {
            unset($_POST['idUsuario']);
            if($usuario->setArrayDados($_POST) > 0){ 
                $this->view->addErros($GLOBALS['ERROS']);
            }else{
                if($this->model->create($usuario)){
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
        $this->criarNovo($usuario);
    }

    /**
     * Método que controla a atualização na tabela 
     *
     */
    public function editarFim()
     {
        $usuario = new Usuario();
        $id = ValidatorUtil::variavelInt($_POST['idUsuario']);
        $usuario->setIdUsuario($id);
        try {
             if($usuario->setArrayDados($_POST) > 0){ 
                 $this->view->addErros($GLOBALS['ERROS']);
             }else{
                 if($this->model->update($usuario)){
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
        $this->editar($usuario);
    }

    /**
     * Método que controla a exclusão de dados na tabela final
     *
     */
    public function deletarFim()
    {
        $usuario = new Usuario();
        $id = ValidatorUtil::variavelInt($GLOBALS['ARGS'][0]);
        $usuario->setIdUsuario($id);
        try {
             if($this->model->delete($usuario) !== false){
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
    private function addArquivos(Usuario $obj, $editar = false)
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
