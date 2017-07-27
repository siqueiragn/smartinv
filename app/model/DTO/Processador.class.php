<?php
/**
 * Classe para a transferencia de dados de Processador entre as 
 * camadas do sistema 
 *
 * @package app.model.dto
 * @author  Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com> 
 * @version 1.0.0 - 25-07-2017(Gerado Automaticamente com GC - 1.0 02/11/2015)
 */

 class Processador implements DTOInterface
 {
    use core\model\DTOTrait;

    private $idProcessador;
    private $nome;
    private $frequencia;
    private $socket;
    private $descricao;
    private $computador;
    private $isValid;
    private $table;

    /**
     * Método Construtor da classe responsável por setar a tabela 
     * e inicializar outras variáveis
     *
     * @param String $table -  Nome da tabela no banco de dados
     */
    public function __construct($table = 'public.processador')
    {
        $this->table = $table;
    }

    /**
     * Método que retorna o valor da variável idProcessador
     *
     * @return Inteiro - Valor da variável idProcessador
     */
    public function getIdProcessador()
     {
        return $this->idProcessador;
    }

    /**
     * Método que seta o valor da variável idProcessador
     *
     * @param Inteiro $idProcessador - Valor da variável idProcessador
     */
    public function setIdProcessador($idProcessador)
    {
         $idProcessador = trim($idProcessador);
          if(empty($idProcessador)){
                $GLOBALS['ERROS'][] = 'O valor informado em Id processador não pode ser nulo!';
                return false;
          }
          if(!(is_numeric($idProcessador) && is_int($idProcessador + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Id processador é um número inteiro inválido!';
                return false;
          }
          $this->idProcessador = $idProcessador;
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
     * Método que retorna o valor da variável frequencia
     *
     * @return Inteiro - Valor da variável frequencia
     */
    public function getFrequencia()
     {
        return $this->frequencia;
    }

    /**
     * Método que seta o valor da variável frequencia
     *
     * @param Inteiro $frequencia - Valor da variável frequencia
     */
    public function setFrequencia($frequencia)
    {
         $frequencia = trim($frequencia);
          if(!(is_numeric($frequencia) && is_int($frequencia + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Frequencia é um número inteiro inválido!';
                return false;
          }
          $this->frequencia = $frequencia;
          return true;
    }

    /**
     * Método que retorna o valor da variável socket
     *
     * @return String - Valor da variável socket
     */
    public function getSocket()
     {
        return $this->socket;
    }

    /**
     * Método que seta o valor da variável socket
     *
     * @param String $socket - Valor da variável socket
     */
    public function setSocket($socket)
    {
         $socket = trim($socket);
         $this->socket = $socket;
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
          if(!(is_numeric($computador) && is_int($computador + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Computador é um número inteiro inválido!';
                return false;
          }
          $this->computador = $computador;
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
             $this->idProcessador,
             $this->nome,
             $this->frequencia,
             $this->socket,
             $this->descricao,
             $this->computador
        );
     }


    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
     public function getID(){
        return $this->idProcessador;
     }

    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
    public function getCondition()
    {
        return 'id_processador = ' . $this->idProcessador;
     }
}
