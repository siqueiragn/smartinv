<?php
namespace core\libs\login;

/**
 * Description of LoginService
 *
 * @author marcio
 */
class LoginService extends Login
{
    private $service = null;
    private $retorno;
    
    /**
     * 
     * @param type $chave
     * @param type $service Url de serviço de autenticação
     */
    public function __construct($chave, $service)
    {
        parent::__construct($chave);
        $this->service = $service;
    }
    
    public function geraSessao($login, $senha){
        $this->geraObjSessao($login, $senha);
    }
    
    public function verificaLoginSenha($login, $senha, $revalidate = false)
    {
        if($revalidate){
            $webService = new \Browser();
            $webService->setUrl($this->service);
            $webService->setRequestArray(array('user' => $login, 'password' => $senha));
            $webService->requisita();
            $this->retorno = json_decode($webService->getResult());
            return $this->retorno;
        }else{
            $str = unserialize($_SESSION['user']);
            if($str->getLogin() == $login){
                return true;
            }else{
                return false;
            }
        }        
    }
    
    public function getRetorno(){
        return $this->retorno;
    }

    

}
