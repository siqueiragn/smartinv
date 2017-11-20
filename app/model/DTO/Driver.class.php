<?php
/**
 * Classe para a transferencia de dados de Driver entre as 
 * camadas do sistema 
 *
 * @package app.model.dto
 * @author  Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com> 
 * @version 1.0.0 - 28-07-2017(Gerado Automaticamente com GC - 1.0 02/11/2015)
 */

 class Driver implements DTOInterface
 {
    use core\model\DTOTrait;

    private $idDriver;
    private $nome;
    private $velocidade;
    private $descricao;
    private $barramento;
    private $computador;
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
     * Método que retorna o valor da variável velocidade
     *
     * @return Inteiro - Valor da variável velocidade
     */
    public function getVelocidade()
     {
        return $this->velocidade;
    }

    /**
     * Método que seta o valor da variável velocidade
     *
     * @param Inteiro $velocidade - Valor da variável velocidade
     */
    public function setVelocidade($velocidade)
    {
         $velocidade = trim($velocidade);
          if(!(is_numeric($velocidade) && is_int($velocidade + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Velocidade é um número inteiro inválido!';
                return false;
          }
          $this->velocidade = $velocidade;
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
     * Método que retorna o valor da variável barramento
     *
     * @return Inteiro - Valor da variável barramento
     */
    public function getBarramento()
     {
        return $this->barramento;
    }

    /**
     * Método que seta o valor da variável barramento
     *
     * @param Inteiro $barramento - Valor da variável barramento
     */
    public function setBarramento($barramento)
    {
         $barramento = trim($barramento);
          if(!(is_numeric($barramento) && is_int($barramento + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Barramento é um número inteiro inválido!';
                return false;
          }
          $this->barramento = $barramento;
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
             $this->idDriver,
             $this->nome,
             $this->velocidade,
             $this->descricao,
             $this->barramento,
             empty($this->computador) ? '' : "<a href='/computador/editar/".$this->computador."'>Ver (".$this->computador.")</a>"
            
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
