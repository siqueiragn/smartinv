<?php
namespace core\libs\login;
#TODO implementar classe.
class LoginBanco extends Login{

    private $tabelaLogin;
    /**
     * Modelo de conexão ao banco de dados
     * @var \AbstractModel 
     */
    private $modelo;
    private $email;
    private $campoIdUsuario;
    private $camposAceitosLogin = array('email');

    /**
     * Construtor que determina qual vai ser a chave criptográfica
     * e qual vai ser a tabela para verificar login e senha
     * 
     * @param String $chave - Chave criptográfica para salgar algoritmo
     * @param String $tabelaLogin
     */
    public function __construct($chave, \AbstractModel $model, $tabelaLogin = 'usuario') {
        $this->tabelaLogin = $tabelaLogin;
        $this->chave = $chave;
        $this->modelo = $model;
        $this->nivel = 0;
        $this->campoIdUsuario = 'id_usuario';
    }
    
    public function ativaDebug(){
        $this->modelo->DB()->debugOn();
    }
    
    /**
     * Método que retorna o valor da variável campoIdUsuario
     *
     * @return String - Valor da variável campoIdUsuario
     */
     public function getCampoIdUsuario(){
         return $this->campoIdUsuario;
     }

    /**
     * Método que seta o valor da variável campoIdUsuario
     *
     * @param String $campoIdUsuario - Valor da variável campoIdUsuario
     */
     public function setCampoIdUsuario($campoIdUsuario){
         $campoIdUsuario = trim($campoIdUsuario);
         $this->campoIdUsuario = $campoIdUsuario;
         return true;
     }
    

    
    public function getUsuario(){
        return $this->usuario;
        
    }
    
    public function getEmail(){
        return $this->email;        
    }
    
    private function montaCondicao($login){
        $login = strtolower($login);
        $cond = '';
        foreach ($this->camposAceitosLogin as $campo){
            $cond .=   $campo ." ='". $login . "' OR ";
        }                
        return rtrim($cond, ' OR ');
    }
    

    public function verificaLoginSenha($login, $senha) {
        $consulta = $this->modelo->queryTable($this->tabelaLogin,
                        'password, '. $this->campoIdUsuario . '',
                        $this->montaCondicao($login));
        $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);
        $resultQtd =  count($resultado);
        if ($resultQtd == 1) {                    
        	$senhaCriptografada = $resultado[0]['password'];
            if ($this->verificaSenha($senha, $senhaCriptografada)) {
            	$this->geraObjSessao($login, $senha);
                $this->userObject->addExtra('id', $resultado[0][$this->campoIdUsuario]);
                $this->nivel = 0;                 
                $_SESSION['user'] = serialize($this->userObject);
                return true; //Autenticação OK
            }
        } else if ($resultQtd > 1) {
            throw new SQLException();
        }
        return false;
    }

    public function getNivelUsuario() {
        return $this->nivel;
    }


    public function recuperaUsuario($usuario, Modelo $modelo) {
        $consulta = $modelo->queryTable($this->tabelaLogin, 'usuario',
                        'id_usuario = ' . $this->idUsuario);
    } 
    
    public function setModelo(Modelo $modelo) {
        $this->modelo = $modelo;
    }
    
    public function gravarLogin(){
        $this->modelo->conecta(BANCO, USUARIO_BANCO, SENHA_BANCO);
           
        $this->modelo->atualizar(   $this->tabelaLogin, 
                                    'sys_ultimo_login = now()',
                                    $this->campoIdUsuario . ' = ' . $this->idUsuario );
        $this->modelo->desconecta();
    }


}