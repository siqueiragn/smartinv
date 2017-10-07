<?php
/**
 * Classe para a transferencia de dados de Memoria entre as 
 * camadas do sistema 
 *
 * @package app.model.dto
 * @author  Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com> 
 * @version 1.0.0 - 06-10-2017(Gerado Automaticamente com GC - 1.0 02/11/2015)
 */

 class Memoria implements DTOInterface
 {
    use core\model\DTOTrait;

    private $idMemoria;
    private $nome;
    private $frequencia;
    private $capacidade;
    private $tipo;
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
    public function __construct($table = 'public.memoria')
    {
        $this->table = $table;
    }

    /**
     * Método que retorna o valor da variável idMemoria
     *
     * @return Inteiro - Valor da variável idMemoria
     */
    public function getIdMemoria()
     {
        return $this->idMemoria;
    }

    /**
     * Método que seta o valor da variável idMemoria
     *
     * @param Inteiro $idMemoria - Valor da variável idMemoria
     */
    public function setIdMemoria($idMemoria)
    {
         $idMemoria = trim($idMemoria);
          if(empty($idMemoria)){
                $GLOBALS['ERROS'][] = 'O valor informado em Id memoria não pode ser nulo!';
                return false;
          }
          if(!(is_numeric($idMemoria) && is_int($idMemoria + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Id memoria é um número inteiro inválido!';
                return false;
          }
          $this->idMemoria = $idMemoria;
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
     * Método que retorna o valor da variável capacidade
     *
     * @return Inteiro - Valor da variável capacidade
     */
    public function getCapacidade()
     {
        return $this->capacidade;
    }

    /**
     * Método que seta o valor da variável capacidade
     *
     * @param Inteiro $capacidade - Valor da variável capacidade
     */
    public function setCapacidade($capacidade)
    {
         $capacidade = trim($capacidade);
          if(!(is_numeric($capacidade) && is_int($capacidade + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Capacidade é um número inteiro inválido!';
                return false;
          }
          $this->capacidade = $capacidade;
          return true;
    }

    /**
     * Método que retorna o valor da variável tipo
     *
     * @return String - Valor da variável tipo
     */
    public function getTipo()
     {
        return $this->tipo;
    }

    /**
     * Método que seta o valor da variável tipo
     *
     * @param String $tipo - Valor da variável tipo
     */
    public function setTipo($tipo)
    {
         $tipo = trim($tipo);
         $this->tipo = $tipo;
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
             $this->idMemoria,
             $this->nome,
             $this->frequencia,
             $this->capacidade,
             $this->tipo,
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
        return $this->idMemoria;
     }

    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
    public function getCondition()
    {
        return 'id_memoria = ' . $this->idMemoria;
     }
}
