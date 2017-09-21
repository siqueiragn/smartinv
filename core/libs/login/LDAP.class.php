<?php

namespace core\libs\login;

/**
 * Classe que extende o Login padrão do Enyalius para poder trabalhar com ActiveDirectory ou LDAP
 * 
 * @author  Marcio Bigolin <marcio.bigolinn@gmail.com>
 */
class LDAP extends Login {

    private $server = null;
    private $ldapConection = null;
    private $prefixo = 'CAMPUSCANOAS\\';
    
    public function __construct($chave)
    {
        parent::__construct($chave);
    }

    /**
     * Método que retorna o valor da variável server
     *
     * @return String - Valor da variável server
     */
    public function getServer() {
        return $this->server;
    }

    /**
     * Método que seta o valor da variável server
     *
     * @param String $server - Valor da variável server
     */
    public function setServer($server) {
        $server = trim($server);
        $this->server = $server;
        return true;
    }
    
    /**
     * ESSE MÉTODO pode gera problemas de segurança
     * 
     * TODO fazer testes do impacto.
     * 
     * @param String $login
     * @param String $senha
     */
    public function fakeLogin($login, $senha){
    	if(!DEBUG){
    		throw new \ProgramacaoException('Você não pode executar o método FakeLogin em ambiente de produção');
    	}
    	$this->geraObjSessao($login, $senha);        
    }

    public function verificaLoginSenha($login, $senha) {

        if ($this->realizaConexao($login, $senha)) {
            $this->geraObjSessao($login, $senha);
        } else {
            unset($_SESSION['user']);
        }
    }

    private function realizaConexao($usuario, $senha) {
        if (empty($usuario) || empty($senha)) {
            throw new \ErrorException('Usuario e senha inválidos');
        }
        $this->makeConection();
        $ldapuser = $this->prefixo . $usuario;
        $ldappass = $senha;
        if ($this->ldapConection) {
            if (!ldap_bind($this->ldapConection, $ldapuser, $ldappass)) {
                throw new \ErrorException('Usuario e senha inválidos');
            }
            return true;
        }
        throw new \DomainException('Não foi possível conectar');
    }

    public function recuperaDados($username) {
        $this->makeConection();
        $ou_dn = "DC=canoas,DC=ifrs,DC=edu,DC=br";
        $filter = "(&(objectCategory=user)(sAMAccountName=$username))";
        $search = ldap_search($this->ldapConection, $ou_dn, $filter);
        $info = ldap_get_entries($this->ldapConection, $search);

        return $info[0];
    }

    public function verificaLogado() {
        if (array_key_exists('user', $_SESSION)) {
            #FIXME Gerar isso de forma segura
            //validar usuario
            return true;
        } else {
            return false;
        }
    }

    public function __destruct() {
        if ($this->ldapConection) {
            ldap_set_option($this->ldapConection, LDAP_OPT_REFERRALS, 0);
        }
    }

    private function makeConection() {
        if (!$this->server) {
            throw new \ProgramacaoException('Você deve setar o servidor de LDAP');
        }
        if (!$this->ldapConection) {
            $this->ldapConection = ldap_connect($this->server);
        }
    }

}
