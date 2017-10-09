<?php
/**
 * Classe para a transferencia de dados de Algoritmo entre as 
 * camadas do sistema 
 *
 * @package app.model.dto
 * @author  Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com> 
 * @version 1.0.0 - 09-10-2017(Gerado Automaticamente com GC - 1.0 02/11/2015)
 */

 class Algoritmo implements DTOInterface
 {
    use core\model\DTOTrait;

    private $idAlgoritmo;
    private $idPlacaMae;
    private $idProcessador;
    private $idFonte;
    private $idMemoria;
    private $idDiscoRigido;
    private $idComputador;
    private $isValid;
    private $table;

    /**
     * Método Construtor da classe responsável por setar a tabela 
     * e inicializar outras variáveis
     *
     * @param String $table -  Nome da tabela no banco de dados
     */
    public function __construct($table = 'public.algoritmo')
    {
        $this->table = $table;
    }

    /**
     * Método que retorna o valor da variável idAlgoritmo
     *
     * @return Inteiro - Valor da variável idAlgoritmo
     */
    public function getIdAlgoritmo()
     {
        return $this->idAlgoritmo;
    }

    /**
     * Método que seta o valor da variável idAlgoritmo
     *
     * @param Inteiro $idAlgoritmo - Valor da variável idAlgoritmo
     */
    public function setIdAlgoritmo($idAlgoritmo)
    {
         $idAlgoritmo = trim($idAlgoritmo);
          if(empty($idAlgoritmo)){
                $GLOBALS['ERROS'][] = 'O valor informado em Id algoritmo não pode ser nulo!';
                return false;
          }
          if(!(is_numeric($idAlgoritmo) && is_int($idAlgoritmo + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Id algoritmo é um número inteiro inválido!';
                return false;
          }
          $this->idAlgoritmo = $idAlgoritmo;
          return true;
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
          if(!(is_numeric($idPlacaMae) && is_int($idPlacaMae + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Id placa mae é um número inteiro inválido!';
                return false;
          }
          $this->idPlacaMae = $idPlacaMae;
          return true;
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
          if(!(is_numeric($idProcessador) && is_int($idProcessador + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Id processador é um número inteiro inválido!';
                return false;
          }
          $this->idProcessador = $idProcessador;
          return true;
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
          if(!(is_numeric($idFonte) && is_int($idFonte + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Id fonte é um número inteiro inválido!';
                return false;
          }
          $this->idFonte = $idFonte;
          return true;
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
          if(!(is_numeric($idMemoria) && is_int($idMemoria + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Id memoria é um número inteiro inválido!';
                return false;
          }
          $this->idMemoria = $idMemoria;
          return true;
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
          if(!(is_numeric($idDiscoRigido) && is_int($idDiscoRigido + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Id disco rigido é um número inteiro inválido!';
                return false;
          }
          $this->idDiscoRigido = $idDiscoRigido;
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
             $this->idAlgoritmo,
             $this->idPlacaMae,
             $this->idProcessador,
             $this->idFonte,
             $this->idMemoria,
             $this->idDiscoRigido,
             $this->idComputador
        );
     }


    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
     public function getID(){
        return $this->idAlgoritmo;
     }

    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
    public function getCondition()
    {
        return 'id_algoritmo = ' . $this->idAlgoritmo;
     }
}
