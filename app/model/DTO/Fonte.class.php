<?php
/**
 * Classe para a transferencia de dados de Fonte entre as 
 * camadas do sistema 
 *
 * @package app.model.dto
 * @author  Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com> 
 * @version 1.0.0 - 25-07-2017(Gerado Automaticamente com GC - 1.0 02/11/2015)
 */

 class Fonte implements DTOInterface
 {
    use core\model\DTOTrait;

    private $idFonte;
    private $nome;
    private $potencia;
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
    public function __construct($table = 'public.fonte')
    {
        $this->table = $table;
    }

    /**
     * Método que retorna o valor da variável idFonte
     *
     * @return Inteiro - Valor da variável idFonte
     */
    public function getIdFonte()
     {
        return $this->idFonte;
    }

    /**
     * Método que seta o valor da variável idFonte
     *
     * @param Inteiro $idFonte - Valor da variável idFonte
     */
    public function setIdFonte($idFonte)
    {
         $idFonte = trim($idFonte);
          if(empty($idFonte)){
                $GLOBALS['ERROS'][] = 'O valor informado em Id fonte não pode ser nulo!';
                return false;
          }
          if(!(is_numeric($idFonte) && is_int($idFonte + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Id fonte é um número inteiro inválido!';
                return false;
          }
          $this->idFonte = $idFonte;
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
     * Método que retorna o valor da variável potencia
     *
     * @return Inteiro - Valor da variável potencia
     */
    public function getPotencia()
     {
        return $this->potencia;
    }

    /**
     * Método que seta o valor da variável potencia
     *
     * @param Inteiro $potencia - Valor da variável potencia
     */
    public function setPotencia($potencia)
    {
         $potencia = trim($potencia);
          if(!(is_numeric($potencia) && is_int($potencia + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Potencia é um número inteiro inválido!';
                return false;
          }
          $this->potencia = $potencia;
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
             $this->idFonte,
             $this->nome,
             $this->potencia,
             $this->descricao,
            empty($this->computador) ? '' : "<a href='/computador/editar/".$this->computador."'>Ver (".$this->computador.")</a>"
            
        );
     }


    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
     public function getID(){
        return $this->idFonte;
     }

    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
    public function getCondition()
    {
        return 'id_fonte = ' . $this->idFonte;
     }
}
