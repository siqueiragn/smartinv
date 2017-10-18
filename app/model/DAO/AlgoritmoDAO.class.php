<?php

/**
 * Classe de modelo referente ao objeto Algoritmo para 
 * a manutenção dos dados no sistema 
 *
 * @package modulos.
 * @author Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0 - 09-10-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class AlgoritmoDAO extends AbstractDAO 
{

    /**
    * Construtor da classe AlgoritmoDAO esse metodo  
    * instancia o Modelo padrão conectando o mesmo ao banco de dados
    *
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Método que retorna um array com a tabela dos dados de Algoritmo
     *
     * @return Array tabela de dados
     */
    public function getTabela(TabelaConsulta $tabela)
    {
        $dados = array();
        $nLinhasCon = $this->queryTable('public.algoritmo', 'count(id_algoritmo) as num');
        $nLinhas = $nLinhasCon->fetch();
        $result = $this->queryTable(  'public.algoritmo ' . $tabela->getcondicao(), 
                                         'id_algoritmo as principal ,
                                          id_placa_mae,
                                          id_processador,
                                          id_fonte,
                                          id_memoria,
                                          id_disco_rigido,
                                          id_computador'
                                       );
        $resultado = array(
            'page' => $tabela->getPagina(),
          'total' => $tabela->calculaPaginacao($nLinhas['num']),
            'records' => $nLinhas['num']
        );
        foreach ($result as $linhaBanco) {
            $row = array();
            $algoritmo = $this->setDados($linhaBanco);
            $row['id'] = $algoritmo->getidAlgoritmo();
            $row['cell'] = $algoritmo->getArrayJson();
            $dados[] = $row;
       }
        $resultado['rows'] = $dados;
        return $resultado;
    }

     /**
     * Método que retorna um objeto do tipo Algoritmo
     * sendo determinado pelo identifcador do mesmo na tabela
     *
     * @param integer $id - Identificador do dado
     * @return Algoritmo - Objeto data transfer
     */
    public function getByID($id) {
        $algoritmo = new Algoritmo();
        $consulta = $this->queryTable($algoritmo->getTable(),
                                         'id_algoritmo as principal ,
                                          id_placa_mae,
                                          id_processador,
                                          id_fonte,
                                          id_memoria,
                                          id_disco_rigido,
                                          id_computador',
                        'id_algoritmo ='. $id );
        if ($consulta) {
            $algoritmo = $this->setDados($consulta->fetch());
            return $algoritmo;
        } else {
             throw new EntradaDeDadosException();
        }
     }
     
     public function getMenorID() {
        $algoritmo = new Algoritmo();
        $consulta = $this->queryTable($algoritmo->getTable(),
                                         'MIN(id_algoritmo)');
        if ($consulta) {
            $algoritmo = $consulta->fetch();
            return $algoritmo;
        } else {
             throw new EntradaDeDadosException();
        }
     }
     
     /**
     * Método que retorna um array de objetos Algoritmo
     * sendo determinado pelo parâmetro $condicao
     *
     * @param String $condicao - Condição da consulta
     * @return Array de objetos Algoritmo
     */
    public function getLista($condicao = false)
    {
        $dados = array();
        $result = $this->queryTable(  'public.algoritmo ', 
                                         'id_algoritmo as principal ,
                                          id_placa_mae,
                                          id_processador,
                                          id_fonte,
                                          id_memoria,
                                          id_disco_rigido,
                                          id_computador',
            $condicao);
        foreach ($result as $linhaBanco) {
            $algoritmo = $this->setDados($linhaBanco);
            $dados[] = $algoritmo;
       }
        return $dados;
    }

    /**
     * Método Private que retorna um objeto setado Algoritmo
     * com objetivo de servir as funções getTabela, getLista e getAlgoritmo
     *
     * @param array $linha
     * @return objeto Algoritmo
     */
    private function setDados($dados)
    {
        $algoritmo = new Algoritmo();
        $algoritmo->setIdAlgoritmo($dados['principal']);
        $algoritmo->setIdPlacaMae($dados['id_placa_mae']);
        $algoritmo->setIdProcessador($dados['id_processador']);
        $algoritmo->setIdFonte($dados['id_fonte']);
        $algoritmo->setIdMemoria($dados['id_memoria']);
        $algoritmo->setIdDiscoRigido($dados['id_disco_rigido']);
        $algoritmo->setIdComputador($dados['id_computador']);
        return $algoritmo;
    }

    /**
     * Método que insere um objeto do tipo Algoritmo
     * na tabela do banco de dados
     *
     * @param Algoritmo Objeto data transfer
     */
    public function inserirEmTransacao(Algoritmo $obj)
    {
        $this->DB()->begin();
        if ($this->save($obj)) {
            $sequencia = 'public.algoritmo_id_algoritmo_seq';
        $id = $this->DB()->lastInsertId($sequencia);
        $this->DB()->commit();
        return $id;
    } else {
        return false;
    }
   }
   
   public function inserirMultiplos(array $algoritmo){
     
       foreach ($algoritmo as $item){
           $query = "INSERT INTO Algoritmo (id_placa_mae,id_processador,id_fonte,id_memoria,id_disco_rigido) VALUES ";
           $query .= "(".$item['id_placa_mae'].",".$item['id_processador'].",".$item['id_fonte'].",".$item['id_memoria'].",".$item['id_disco_rigido'].")";
           $this->DB()->query($query);
       }
     

       
   }
}