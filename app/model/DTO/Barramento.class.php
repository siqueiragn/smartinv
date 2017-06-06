<?php
/**
 * Classe para a transferencia de dados de Barramento entre as 
 * camadas do sistema 
 *
 * @package app.model.dto
 * @author  Marcio Bigolin <marcio.bigolinn@gmail.com> 
 * @version 1.0.0 - 06-06-2017(Gerado Automaticamente com GC - 1.0 02/11/2015)
 */

 class Barramento implements DTOInterface
 {
    use core\model\DTOTrait;

    private $idBarramento;
    private $nome;
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
    public function __construct($table = 'public.barramento')
    {
        $this->table = $table;
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
             $this->idBarramento,
             $this->nome,
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
        return $this->idBarramento;
     }

    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
    public function getCondition()
    {
        return 'id_barramento = ' . $this->idBarramento;
     }
}
