<?php

namespace core\libs\login;

#TODO implementar classe.
/**
 * 
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 */
abstract class Login
{

    protected $login;
    protected $senha;
    protected $chave;
    protected $nivel;
    protected $redirect = false;

    /**
     *
     * @var User 
     */
    protected $userObject = null;

    /**
     * Construtor que determina qual vai ser a chave criptográfica
     * e qual vai ser a tabela para verificar login e senha
     * 
     * @param String $chave - Chave criptográfica para salgar algoritmo
     */
    public function __construct($chave)
    {
        $this->chave = $chave;
        $this->nivel = 0;
        if (isset($_SESSION['LOGIN_REDIRECTION'])) {
            $this->redirect = $_SESSION['LOGIN_REDIRECTION'];
        }
    }

    public abstract function verificaLoginSenha($login, $senha);

    public function getNivelUsuario()
    {
        return $this->nivel;
    }

    public function addValue($key, $value)
    {
        $this->userObject->addExtra($key, $value);
    }

    public function getValue($key)
    {
        return $this->userObject->getExtra($key);
    }

    /**
     * Método que verifica se existe um usuário logado.
     * 
     * 
     * @return boolean
     */
    public function verificaLogado()
    {
        if (array_key_exists('user', $_SESSION)) {
            $this->userObject = unserialize($_SESSION['user']);   
            return $this->verificaLoginSenha($this->userObject->getLogin(), $this->userObject->getPass());
        } else {
            return false;
        }
    }

    /**
     * 
     * @param type $senhaUsuario
     * @param type $senhaBanco
     * @return boolean
     */
    protected function verificaSenha($senhaUsuario, $senhaBanco)
    {
        if (strcmp($this->criptografaSenha($senhaUsuario), $senhaBanco) === 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function geraObjSessao($login, $senha)
    {
        $this->userObject = new User($login);
        $this->userObject->setPass($senha);
        $_SESSION['user'] = serialize($this->userObject);
    }

    /**
     * Metodo que será chamado na serialização do objeto
     * Este metodo retorna um array com os nomes dos campos que
     * serão guardados
     *
     * @return array
     */
    public function __sleep()
    {
        return array('idLogin', 'senha');
    }

    public function logout()
    {
        unset($_SESSION['user']);
        $this->userObject = null;
    }

    /**
     * 
     * @param String $senha
     * @return String
     */
    public function criptografaSenha($senha)
    {
        return sha1(md5($this->chave . sha1($senha) . $this->chave));
    }

    public function saveRedirect()
    {
        $_SESSION['LOGIN_REDIRECTION'] = filter_var($_SERVER['REQUEST_URI']);
    }

    /**
     * Método que verifica se foi enviado um link anteriormente para fazer o 
     * redirect automatico
     * 
     * @param \AbstractController $c
     * @param type $redirect
     */
    public function redirect(\AbstractController $c, $redirect)
    {
        if (isset($_SESSION['LOGIN_REDIRECTION'])){
            $r = $_SESSION['LOGIN_REDIRECTION'];
            unset($_SESSION['LOGIN_REDIRECTION']);
            $c->redirect($r);
        } else {
            $c->redirect($redirect);
        }
    }

    /**
     * Método destrutor se o objeto de usuario não estiver vazio salva as alterações.
     */
    public function __destruct()
    {
        if ($this->userObject !== null) {
            $_SESSION['user'] = serialize($this->userObject);
        }
    }

}
