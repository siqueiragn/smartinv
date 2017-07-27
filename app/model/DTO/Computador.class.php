<?php
/**
 * Classe para a transferencia de dados de Computador entre as 
 * camadas do sistema 
 *
 * @package app.model.dto
 * @author  Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com> 
 * @version 1.0.0 - 25-07-2017(Gerado Automaticamente com GC - 1.0 02/11/2015)
 */

 class Computador implements DTOInterface
 {
    use core\model\DTOTrait;

    private $idComputador;
    private $nome;
    private $descricao;
    private $isValid;
    private $table;

    /**
     * Método Construtor da classe responsável por setar a tabela 
     * e inicializar outras variáveis
     *
     * @param String $table -  Nome da tabela no banco de dados
     */
    public function __construct($table = 'public.computador')
    {
        $this->table = $table;
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
          if(empty($idComputador)){
                $GLOBALS['ERROS'][] = 'O valor informado em Id computador não pode ser nulo!';
                return false;
          }
          if(!(is_numeric($idComputador) && is_int($idComputador + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Id computador é um número inteiro inválido!';
                return false;
          }
          $this->idComputador = $idComputador;
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
             $this->idComputador,
             $this->nome,
             $this->descricao
        );
     }


    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
     public function getID(){
        return $this->idComputador;
     }

    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
    public function getCondition()
    {
        return 'id_computador = ' . $this->idComputador;
     }
}
