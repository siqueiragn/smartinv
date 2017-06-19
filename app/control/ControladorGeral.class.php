<?php
use core\libs\login\LoginBanco;
/**
 * Classe principal do sistema responsável por criar a interface padrão assim como verificar 
 * a sessão e permissões do usuário.
 * 
 * @author Gabriel Nunes de Siqueira - <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0
 */
class ControladorGeral extends AbstractController
{

    private $conteudoMenu;
    protected $modelo;

    /**
     *
     * @var LoginBanco 
     */
    protected $login;

    public function __construct()
    {
        $this->modelo = new Modelo();
        $this->view = new VisualizadorGeral();
        $this->login = new LoginBanco(LOGIN_CHAVE, $this->modelo);

//         if (!$this->verificaLogado()) {
//             $this->login->saveRedirect();
//             $this->redirect('/login');
//             exit();
//         }
    }

    public function paginaNaoEncontrada()
    {
        $this->view->setTitle('N�o encontrada');
    }

    public function index()
    {
    	//$this->view = null;
    	$this->view = new VisualizadorRegistro();
    	/*
        $this->view->setTitle('SMARTINV - 2017');
        $this->view->addTemplate("menuLogin");
        
*/
    }

    public function home()
    {
        $this->view = new VisualizadorGeral();
        /* $controlador = new ControladorGeral();
        $this->view = $controlador->getView(); */
    }

    public function contato()
    {
        $this->view->setTitle('Contato');
        $this->view->startForm('contatoFim');
        $this->view->addTemplate('paginas/contato');
        $this->view->endForm();
    }

    public function contatoFim()
    {
        extract($_POST);
        $mensagem = "==============================================================================" . PHP_EOL;
        $mensagem.="NOME: " . $nome . PHP_EOL;
        $mensagem.="E_MAIL: " . $email . PHP_EOL;
        $mensagem.="==============================================================================" . PHP_EOL;
        $mensagem.="MENSAGEM:" . PHP_EOL;
        $mensagem.=$texto . PHP_EOL;
        $mensagem.="==============================================================================" . PHP_EOL;
        if (MailUtil::sendMail(MAIL_USER, "marcio.bigolinn@gmail.com", "[" . $assunto . "] Email de " . $nome, $mensagem)) {
            $this->view->setTitle('Sucesso ao enviar sua mensagem!');
            $this->view->addMensagemSucesso('Sua mensagem foi enviada com sucesso, em breve retornaremos.');
        } else {
            $this->view->setTitle('Ocorreu um erro ao enviar sua mensagem!');
            $this->view->addMensagemErro('Estamos passando por dificuldades técnicas tente novamente mais tarde.');
        }
    }
    
    public function componentes(){
    	$this->view->setTitle('Componentes');
    	$this->view->addTemplate('componentes');
    }
    
 

    public function __destruct()
    {
    	if(get_class($this->view)=='VisualizadorRegistro' || $this->view->getTitle() == 'Componentes')
    		$this->view->addTemplate('rodapeLogin');
    	else
    	$this->view->addTemplate('rodape');
    	parent::__destruct();
    }
    
    
      private function verificaLogado()
    {
        return $this->login->verificaLogado();
    }

}
