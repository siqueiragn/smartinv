<?php
/**
 * Classe para a transferencia de dados de PlacaMae entre as 
 * camadas do sistema 
 *
 * @package app.model.dto
 * @author  Marcio Bigolin <marcio.bigolinn@gmail.com> 
 * @version 1.0.0 - 06-06-2017(Gerado Automaticamente com GC - 1.0 02/11/2015)
 */

 class PlacaMae implements DTOInterface
 {
    use core\model\DTOTrait;

    private $idPlacaMae;
    private $nome;
    private $socket;
    private $portasUsb;
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
    public function __construct($table = 'public.placa_mae')
    {
        $this->table = $table;
    }

    /**
     * Método que retorna o valor da variável idPlacaMae
     *
     * @return Inteiro - Valor da variável idPlacaMae
     */
    public function getIdPlacaMae()
     {
        return $this->idPlacaMae;
    }

    /**
     * Método que seta o valor da variável idPlacaMae
     *
     * @param Inteiro $idPlacaMae - Valor da variável idPlacaMae
     */
    public function setIdPlacaMae($idPlacaMae)
    {
         $idPlacaMae = trim($idPlacaMae);
          if(empty($idPlacaMae)){
                $GLOBALS['ERROS'][] = 'O valor informado em Id placa mae não pode ser nulo!';
                return false;
          }
          if(!(is_numeric($idPlacaMae) && is_int($idPlacaMae + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Id placa mae é um número inteiro inválido!';
                return false;
          }
          $this->idPlacaMae = $idPlacaMae;
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
     * Método que retorna o valor da variável socket
     *
     * @return Inteiro - Valor da variável socket
     */
    public function getSocket()
     {
        return $this->socket;
    }

    /**
     * Método que seta o valor da variável socket
     *
     * @param Inteiro $socket - Valor da variável socket
     */
    public function setSocket($socket)
    {
         $socket = trim($socket);
          if(!(is_numeric($socket) && is_int($socket + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Socket é um número inteiro inválido!';
                return false;
          }
          $this->socket = $socket;
          return true;
    }

    /**
     * Método que retorna o valor da variável portasUsb
     *
     * @return Inteiro - Valor da variável portasUsb
     */
    public function getPortasUsb()
     {
        return $this->portasUsb;
    }

    /**
     * Método que seta o valor da variável portasUsb
     *
     * @param Inteiro $portasUsb - Valor da variável portasUsb
     */
    public function setPortasUsb($portasUsb)
    {
         $portasUsb = trim($portasUsb);
          if(!(is_numeric($portasUsb) && is_int($portasUsb + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Portas usb é um número inteiro inválido!';
                return false;
          }
          $this->portasUsb = $portasUsb;
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
             $this->idPlacaMae,
             $this->nome,
             $this->socket,
             $this->portasUsb,
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
        return $this->idPlacaMae;
     }

    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
    public function getCondition()
    {
        return 'id_placa_mae = ' . $this->idPlacaMae;
     }
}