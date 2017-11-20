<?php
/**
 * Classe para a transferencia de dados de DiscoRigido entre as 
 * camadas do sistema 
 *
 * @package app.model.dto
 * @author  Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com> 
 * @version 1.0.0 - 28-07-2017(Gerado Automaticamente com GC - 1.0 02/11/2015)
 */

 class DiscoRigido implements DTOInterface
 {
    use core\model\DTOTrait;

    private $idDiscoRigido;
    private $nome;
    private $capacidade;
    private $vCache;
    private $rpm;
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
    public function __construct($table = 'public.disco_rigido')
    {
        $this->table = $table;
    }

    /**
     * Método que retorna o valor da variável idDiscoRigido
     *
     * @return Inteiro - Valor da variável idDiscoRigido
     */
    public function getIdDiscoRigido()
     {
        return $this->idDiscoRigido;
    }

    /**
     * Método que seta o valor da variável idDiscoRigido
     *
     * @param Inteiro $idDiscoRigido - Valor da variável idDiscoRigido
     */
    public function setIdDiscoRigido($idDiscoRigido)
    {
         $idDiscoRigido = trim($idDiscoRigido);
          if(empty($idDiscoRigido)){
                $GLOBALS['ERROS'][] = 'O valor informado em Id disco rigido não pode ser nulo!';
                return false;
          }
          if(!(is_numeric($idDiscoRigido) && is_int($idDiscoRigido + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Id disco rigido é um número inteiro inválido!';
                return false;
          }
          $this->idDiscoRigido = $idDiscoRigido;
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
     * Método que retorna o valor da variável vCache
     *
     * @return Inteiro - Valor da variável vCache
     */
    public function getVCache()
     {
        return $this->vCache;
    }

    /**
     * Método que seta o valor da variável vCache
     *
     * @param Inteiro $vCache - Valor da variável vCache
     */
    public function setVCache($vCache)
    {
         $vCache = trim($vCache);
          if(!(is_numeric($vCache) && is_int($vCache + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em V cache é um número inteiro inválido!';
                return false;
          }
          $this->vCache = $vCache;
          return true;
    }

    /**
     * Método que retorna o valor da variável rpm
     *
     * @return Inteiro - Valor da variável rpm
     */
    public function getRpm()
     {
        return $this->rpm;
    }

    /**
     * Método que seta o valor da variável rpm
     *
     * @param Inteiro $rpm - Valor da variável rpm
     */
    public function setRpm($rpm)
    {
         $rpm = trim($rpm);
          if(!(is_numeric($rpm) && is_int($rpm + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Rpm é um número inteiro inválido!';
                return false;
          }
          $this->rpm = $rpm;
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
             $this->idDiscoRigido,
             $this->nome,
             $this->capacidade,
             $this->vCache,
             $this->rpm,
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
        return $this->idDiscoRigido;
     }

    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
    public function getCondition()
    {
        return 'id_disco_rigido = ' . $this->idDiscoRigido;
     }
}
