<?php

/**
 * Classe de modelo referente ao objeto Driver para 
 * a manutenção dos dados no sistema 
 *
 * @package modulos.
 * @author Gabriel <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0 - 13-06-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class DriverDAO extends AbstractDAO 
{

    /**
    * Construtor da classe DriverDAO esse metodo  
    * instancia o Modelo padrão conectando o mesmo ao banco de dados
    *
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Método que retorna um array com a tabela dos dados de Driver
     *
     * @return Array tabela de dados
     */
    public function getTabela(TabelaConsulta $tabela)
    {
        $dados = array();
        $nLinhasCon = $this->queryTable('public.driver', 'count(id_driver) as num');
        $nLinhas = $nLinhasCon->fetch();
        $result = $this->queryTable(  'public.driver ' . $tabela->getcondicao(), 
                                         'id_driver as principal ,
                                          nome,
                                          descricao,
                                          computador,
                                          id_barramento,
                                          id_computador'
                                       );
        $resultado = array(
            'page' => $tabela->getPagina(),
          'total' => $tabela->calculaPaginacao($nLinhas['num']),
            'records' => $nLinhas['num']
        );
        foreach ($result as $linhaBanco) {
            $row = array();
            $driver = $this->setDados($linhaBanco);
            $row['id'] = $driver->getidDriver();
            $row['cell'] = $driver->getArrayJson();
            $dados[] = $row;
       }
        $resultado['rows'] = $dados;
        return $resultado;
    }

     /**
     * Método que retorna um objeto do tipo Driver
     * sendo determinado pelo identifcador do mesmo na tabela
     *
     * @param integer $id - Identificador do dado
     * @return Driver - Objeto data transfer
     */
    public function getByID($id) {
        $driver = new Driver();
        $consulta = $this->queryTable($driver->getTable(),
                                         'id_driver as principal ,
                                          nome,
                                          descricao,
                                          computador,
                                          id_barramento,
                                          id_computador',
                        'id_driver ='. $id );
        if ($consulta) {
            $driver = $this->setDados($consulta->fetch());
            return $driver;
        } else {
             throw new EntradaDeDadosException();
        }
     }
     /**
     * Método que retorna um array de objetos Driver
     * sendo determinado pelo parâmetro $condicao
     *
     * @param String $condicao - Condição da consulta
     * @return Array de objetos Driver
     */
    public function getLista($condicao = false)
    {
        $dados = array();
        $result = $this->queryTable(  'public.driver ', 
                                         'id_driver as principal ,
                                          nome,
                                          descricao,
                                          computador,
                                          id_barramento,
                                          id_computador',
            $condicao);
        foreach ($result as $linhaBanco) {
            $driver = $this->setDados($linhaBanco);
            $dados[] = $driver;
       }
        return $dados;
    }

    /**
     * Método Private que retorna um objeto setado Driver
     * com objetivo de servir as funções getTabela, getLista e getDriver
     *
     * @param array $linha
     * @return objeto Driver
     */
    private function setDados($dados)
    {
        $driver = new Driver();
        $driver->setIdDriver($dados['principal']);
        $driver->setNome($dados['nome']);
        $driver->setDescricao($dados['descricao']);
        $driver->setComputador($dados['computador']);
        $driver->setIdBarramento($dados['id_barramento']);
        $driver->setIdComputador($dados['id_computador']);
        return $driver;
    }

    /**
     * Método que insere um objeto do tipo Driver
     * na tabela do banco de dados
     *
     * @param Driver Objeto data transfer
     */
    public function inserirEmTransacao(Driver $obj)
    {
        $this->DB()->begin();
        if ($this->save($obj)) {
            $sequencia = 'public.driver_id_driver_seq';
        $id = $this->DB()->lastInsertId($sequencia);
        $this->DB()->commit();
        return $id;
    } else {
        return false;
    }
   }
}