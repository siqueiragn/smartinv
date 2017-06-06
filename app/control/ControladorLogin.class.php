<?php

use core\libs\login\LoginBanco;

/**
 * Classe principal do sistema responsável por criar a interface padrão assim como verificar
 * a sessão e permissões do usuário.
 *
 * @author Marcio Bigolin - <marcio.bigolinn@gmail.com>
 * @version 1.0.0
 */
class ControladorLogin extends AbstractController
{

    /**
     *
     * @var ModeloLogin 
     */
    private $modelo;

    public function __construct()
    {
        $this->modelo = new ModeloLogin();
        $this->view = new VisualizadorLogin();
    }

    public function paginaNaoEncontrada()
    {
        $this->view->setTitle('Funcionalidade ainda não implementada');
    }

    public function index()
    {
        $this->view->setTitle('Logar no sistema');
        $this->view->attValue('url', $_SERVER['HTTP_HOST']);
        $this->view->addTemplate('nao_logado');
        $this->view->addJS('login/main.js');
    }

    public function valida()
    {
        $usuario = filter_input(INPUT_POST, 'usuario');
        $senha = filter_input(INPUT_POST, 'senha');

        $login = new LoginBanco(LOGIN_CHAVE, $this->modelo);
        $this->modelo->DB()->debugOn();

        $result = $login->verificaLoginSenha($usuario, $senha, true);
        if ($result) {
            $login->redirect($this, '/');
            exit();
        } else {
            $this->view->addErro('Login e Senha incorreto');
        }

        $this->index();
    }

    public function registrar()
    {
        
    }

    public function getTemplateCadastro()
    {
        $this->view->addTemplate('cadastro');
        $this->view->setRenderizado();
    }

    public function imagem()
    {
        
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        $this->redirect('/');
    }

}
