<?php
/**
 * Classe para a transferencia de dados de Usuario entre as 
 * camadas do sistema 
 *
 * @package app.model.dto
 * @author  Gabriel <gabrielndesiqueira@hotmail.com> 
 * @version 1.0.0 - 13-06-2017(Gerado Automaticamente com GC - 1.0 02/11/2015)
 */

 class Usuario implements DTOInterface
 {
    use core\model\DTOTrait;

    private $idUsuario;
    private $login;
    private $password;
    private $email;
    private $isValid;
    private $table;

    /**
     * Método Construtor da classe responsável por setar a tabela 
     * e inicializar outras variáveis
     *
     * @param String $table -  Nome da tabela no banco de dados
     */
    public function __construct($table = 'public.usuario')
    {
        $this->table = $table;
    }

    /**
     * Método que retorna o valor da variável idUsuario
     *
     * @return Inteiro - Valor da variável idUsuario
     */
    public function getIdUsuario()
     {
        return $this->idUsuario;
    }

    /**
     * Método que seta o valor da variável idUsuario
     *
     * @param Inteiro $idUsuario - Valor da variável idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
         $idUsuario = trim($idUsuario);
          if(empty($idUsuario)){
                $GLOBALS['ERROS'][] = 'O valor informado em Id usuário não pode ser nulo!';
                return false;
          }
          if(!(is_numeric($idUsuario) && is_int($idUsuario + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Id usuário é um número inteiro inválido!';
                return false;
          }
          $this->idUsuario = $idUsuario;
          return true;
    }

    /**
     * Método que retorna o valor da variável login
     *
     * @return String - Valor da variável login
     */
    public function getLogin()
     {
        return $this->login;
    }

    /**
     * Método que seta o valor da variável login
     *
     * @param String $login - Valor da variável login
     */
    public function setLogin($login)
    {
         $login = trim($login);
          if(empty($login)){
                $GLOBALS['ERROS'][] = 'O valor informado em Login não pode ser nulo!';
                return false;
          }
         $this->login = $login;
         return true;
    }

    /**
     * Método que retorna o valor da variável password
     *
     * @return String - Valor da variável password
     */
    public function getPassword()
     {
        return $this->password;
    }

    /**
     * Método que seta o valor da variável password
     *
     * @param String $password - Valor da variável password
     */
    public function setPassword($password)
    {
         $password = trim($password);
          if(empty($password)){
                $GLOBALS['ERROS'][] = 'O valor informado em Password não pode ser nulo!';
                return false;
          }
         $this->password = $password;
         return true;
    }

    /**
     * Método que retorna o valor da variável email
     *
     * @return String - Valor da variável email
     */
    public function getEmail()
     {
        return $this->email;
    }

    /**
     * Método que seta o valor da variável email
     *
     * @param String $email - Valor da variável email
     */
    public function setEmail($email)
    {
         $email = trim($email);
          if(empty($email)){
                $GLOBALS['ERROS'][] = 'O valor informado em Email não pode ser nulo!';
                return false;
          }
         $this->email = $email;
         return true;
    }

    /**
     * Método que retorna o valor da variável $tabela 
     *
     * @return String - Tabela do SGBD
     */
     public function getTable()
    {
        return $this->table;
     }

     public function setTable($table)
    {
        $this->table = $table;
     }

    /**
     * Método responsável por retornar um array em formato JSON 
     * para poder ser utilizado como Objeto Java Script
     *
     * @return Array -  Array JSON
     */
     public function getArrayJSON()
     {
        return array(
             $this->idUsuario,
             $this->login,
             $this->password,
             $this->email
        );
     }


    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
     public function getID(){
        return $this->idUsuario;
     }

    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
    public function getCondition()
    {
        return 'id_usuario = ' . $this->idUsuario;
     }
}
