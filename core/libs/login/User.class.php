<?php

namespace core\libs\login;

/**
 * Classe responsável por ser um DTO padronizado para manter o enyalius logado em todas
 * as páginas
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 */
class User implements \JsonSerializable
{
    private $id = null;
    private $login = null;
    private $pass = null;
    private $access = 1000;
    /**
     * Pack no padrão chave=>valor para adicionar propriedades no objeto de login
     * 
     * @var array 
     */
    private $extras = array();
    private $aes ; 
    
    public function __construct($login)
    {
        $this->login = $login;
        $this->aes = new \Aes();
    }
    
    public function addExtra($key, $value){
        $this->extras[$key] = $value;
    }
    
    public function getExtra($key){
        if(!isset($this->extras[$key])){
            return '';
        }
        return $this->extras[$key];
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getPass()
    {
        if(empty($this->aes)){
            $this->aes = new \Aes();
        }
        return $this->aes->decrypt($this->pass);
    }

    public function getAccess()
    {
        return $this->access;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    public function setPass($pass)
    {
        $this->pass = $this->aes->crypt($pass);
        return $this;
    }

    public function setAccess($access)
    {
        $this->access = $access;
        return $this;
    }


    public function __sleep() {
        return array('id', 'login', 'access', 'extras', 'pass');
    }

    public function jsonSerialize()
    {
        return array(   'id' => $this->id,
                        'login' => $this->login, 
                        'data' => json_encode ($this->extras));
    }

}
