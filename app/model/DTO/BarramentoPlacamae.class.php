<?php
/**
 * Classe para a transferencia de dados de BarramentoPlacamae entre as 
 * camadas do sistema 
 *
 * @package app.model.dto
 * @author  Gabriel <gabrielndesiqueira@hotmail.com> 
 * @version 1.0.0 - 13-06-2017(Gerado Automaticamente com GC - 1.0 02/11/2015)
 */

 class BarramentoPlacamae implements DTOInterface
 {
    use core\model\DTOTrait;

    private $idBarramentoPlacamae;
    private $idBarramento;
    private $idPlacaMae;
    private $isValid;
    private $table;

    /**
     * Método Construtor da classe responsável por setar a tabela 
     * e inicializar outras variáveis
     *
     * @param String $table -  Nome da tabela no banco de dados
     */
    public function __construct($table = 'public.barramento_placamae')
    {
        $this->table = $table;
    }

    /**
     * Método que retorna o valor da variável idBarramentoPlacamae
     *
     * @return Inteiro - Valor da variável idBarramentoPlacamae
     */
    public function getIdBarramentoPlacamae()
     {
        return $this->idBarramentoPlacamae;
    }

    /**
     * Método que seta o valor da variável idBarramentoPlacamae
     *
     * @param Inteiro $idBarramentoPlacamae - Valor da variável idBarramentoPlacamae
     */
    public function setIdBarramentoPlacamae($idBarramentoPlacamae)
    {
         $idBarramentoPlacamae = trim($idBarramentoPlacamae);
          if(empty($idBarramentoPlacamae)){
                $GLOBALS['ERROS'][] = 'O valor informado em Id barramento placamae não pode ser nulo!';
                return false;
          }
          if(!(is_numeric($idBarramentoPlacamae) && is_int($idBarramentoPlacamae + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Id barramento placamae é um número inteiro inválido!';
                return false;
          }
          $this->idBarramentoPlacamae = $idBarramentoPlacamae;
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
             $this->idBarramentoPlacamae,
             $this->idBarramento,
             $this->idPlacaMae
        );
     }


    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
     public function getID(){
        return $this->idBarramentoPlacamae;
     }

    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
    public function getCondition()
    {
        return 'id_barramento_placamae = ' . $this->idBarramentoPlacamae;
     }
}
