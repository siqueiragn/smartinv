<?php
/**
 * Classe para a transferencia de dados de Driver entre as 
 * camadas do sistema 
 *
 * @package app.model.dto
 * @author  Gabriel <gabrielndesiqueira@hotmail.com> 
 * @version 1.0.0 - 13-06-2017(Gerado Automaticamente com GC - 1.0 02/11/2015)
 */

 class Driver implements DTOInterface
 {
    use core\model\DTOTrait;

    private $idDriver;
    private $nome;
    private $descricao;
    private $computador;
    private $idBarramento;
    private $idComputador;
    private $isValid;
    private $table;

    /**
     * Método Construtor da classe responsável por setar a tabela 
     * e inicializar outras variáveis
     *
     * @param String $table -  Nome da tabela no banco de dados
     */
    public function __construct($table = 'public.driver')
    {
        $this->table = $table;
    }

    /**
     * Método que retorna o valor da variável idDriver
     *
     * @return Inteiro - Valor da variável idDriver
     */
    public function getIdDriver()
     {
        return $this->idDriver;
    }

    /**
     * Método que seta o valor da variável idDriver
     *
     * @param Inteiro $idDriver - Valor da variável idDriver
     */
    public function setIdDriver($idDriver)
    {
         $idDriver = trim($idDriver);
          if(empty($idDriver)){
                $GLOBALS['ERROS'][] = 'O valor informado em Id driver não pode ser nulo!';
                return false;
          }
          if(!(is_numeric($idDriver) && is_int($idDriver + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Id driver é um número inteiro inválido!';
                return false;
          }
          $this->idDriver = $idDriver;
          return true;
    }

    /**
     * Método que retorna o valor da variável nome
     *
     * @return String - Valor da variável nome
     */
    public function getNome()
     {
        return $this->nome;
    }

    /**
     * Método que seta o valor da variável nome
     *
     * @param String $nome - Valor da variável nome
     */
    public function setNome($nome)
    {
         $nome = trim($nome);
         $this->nome = $nome;
         return true;
    }

    /**
     * Método que retorna o valor da variável descricao
     *
     * @return String - Valor da variável descricao
     */
    public function getDescricao()
     {
        return $this->descricao;
    }

    /**
     * Método que seta o valor da variável descricao
     *
     * @param String $descricao - Valor da variável descricao
     */
    public function setDescricao($descricao)
    {
         $descricao = trim($descricao);
         $this->descricao = $descricao;
         return true;
    }

    /**
     * Método que retorna o valor da variável computador
     *
     * @return Inteiro - Valor da variável computador
     */
    public function getComputador()
     {
        return $this->computador;
    }

    /**
     * Método que seta o valor da variável computador
     *
     * @param Inteiro $computador - Valor da variável computador
     */
    public function setComputador($computador)
    {
         $computador = trim($computador);
          if(empty($computador)){
                $GLOBALS['ERROS'][] = 'O valor informado em Computador não pode ser nulo!';
                return false;
          }
          if(!(is_numeric($computador) && is_int($computador + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Computador é um número inteiro inválido!';
                return false;
          }
          $this->computador = $computador;
          return true;
    }

    /**
     * Método que retorna o valor da variável idBarramento
     *
     * @return Inteiro - Valor da variável idBarramento
     */
    public function getIdBarramento()
     {
        return $this->idBarramento;
    }

    /**
     * Método que seta o valor da variável idBarramento
     *
     * @param Inteiro $idBarramento - Valor da variável idBarramento
     */
    public function setIdBarramento($idBarramento)
    {
         $idBarramento = trim($idBarramento);
          if(empty($idBarramento)){
                $GLOBALS['ERROS'][] = 'O valor informado em Id barramento não pode ser nulo!';
                return false;
          }
          if(!(is_numeric($idBarramento) && is_int($idBarramento + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Id barramento é um número inteiro inválido!';
                return false;
          }
          $this->idBarramento = $idBarramento;
          return true;
    }

    /**
     * Método que retorna o valor da variável idComputador
     *
     * @return Inteiro - Valor da variável idComputador
     */
    public function getIdComputador()
     {
        return $this->idComputador;
    }

    /**
     * Método que seta o valor da variável idComputador
     *
     * @param Inteiro $idComputador - Valor da variável idComputador
     */
    public function setIdComputador($idComputador)
    {
         $idComputador = trim($idComputador);
          if(!(is_numeric($idComputador) && is_int($idComputador + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Id computador é um número inteiro inválido!';
                return false;
          }
          $this->idComputador = $idComputador;
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
             $this->idDriver,
             $this->nome,
             $this->descricao,
             $this->computador,
             $this->idBarramento,
             $this->idComputador
        );
     }


    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
     public function getID(){
        return $this->idDriver;
     }

    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
    public function getCondition()
    {
        return 'id_driver = ' . $this->idDriver;
     }
}
