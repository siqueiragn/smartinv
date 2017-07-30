<?php
/**
 * Classe para a transferencia de dados de PlacaVideo entre as 
 * camadas do sistema 
 *
 * @package app.model.dto
 * @author  Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com> 
 * @version 1.0.0 - 28-07-2017(Gerado Automaticamente com GC - 1.0 02/11/2015)
 */

 class PlacaVideo implements DTOInterface
 {
    use core\model\DTOTrait;

    private $idPlacaVideo;
    private $nome;
    private $frequencia;
    private $memoria;
    private $tipo;
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
    public function __construct($table = 'public.placa_video')
    {
        $this->table = $table;
    }

    /**
     * Método que retorna o valor da variável idPlacaVideo
     *
     * @return Inteiro - Valor da variável idPlacaVideo
     */
    public function getIdPlacaVideo()
     {
        return $this->idPlacaVideo;
    }

    /**
     * Método que seta o valor da variável idPlacaVideo
     *
     * @param Inteiro $idPlacaVideo - Valor da variável idPlacaVideo
     */
    public function setIdPlacaVideo($idPlacaVideo)
    {
         $idPlacaVideo = trim($idPlacaVideo);
          if(empty($idPlacaVideo)){
                $GLOBALS['ERROS'][] = 'O valor informado em Id placa video não pode ser nulo!';
                return false;
          }
          if(!(is_numeric($idPlacaVideo) && is_int($idPlacaVideo + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Id placa video é um número inteiro inválido!';
                return false;
          }
          $this->idPlacaVideo = $idPlacaVideo;
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
     * Método que retorna o valor da variável memoria
     *
     * @return Inteiro - Valor da variável memoria
     */
    public function getMemoria()
     {
        return $this->memoria;
    }

    /**
     * Método que seta o valor da variável memoria
     *
     * @param Inteiro $memoria - Valor da variável memoria
     */
    public function setMemoria($memoria)
    {
         $memoria = trim($memoria);
          if(!(is_numeric($memoria) && is_int($memoria + 0))){
                $GLOBALS['ERROS'][] = 'O valor informado em Memoria é um número inteiro inválido!';
                return false;
          }
          $this->memoria = $memoria;
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
             $this->idPlacaVideo,
             $this->nome,
             $this->frequencia,
             $this->memoria,
             $this->tipo,
             $this->descricao,
             $this->barramento,
             $this->computador
        );
     }


    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
     public function getID(){
        return $this->idPlacaVideo;
     }

    /**
     * Método utilizado como condição de seleção de chave primária
     *
     * @return String - Condição para selecionar um dado unico na tabela
     */
    public function getCondition()
    {
        return 'id_placa_video = ' . $this->idPlacaVideo;
     }
}
