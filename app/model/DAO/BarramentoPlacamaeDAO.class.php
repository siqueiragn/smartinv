<?php

/**
 * Classe de modelo referente ao objeto BarramentoPlacamae para 
 * a manutenção dos dados no sistema 
 *
 * @package modulos.
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0.0 - 06-06-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class BarramentoPlacamaeDAO extends AbstractDAO 
{

    /**
    * Construtor da classe BarramentoPlacamaeDAO esse metodo  
    * instancia o Modelo padrão conectando o mesmo ao banco de dados
    *
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Método que retorna um array com a tabela dos dados de Barramento placamae
     *
     * @return Array tabela de dados
     */
    public function getTabela(TabelaConsulta $tabela)
    {
        $dados = array();
        $nLinhasCon = $this->queryTable('public.barramento_placamae', 'count(id_barramento_placamae) as num');
        $nLinhas = $nLinhasCon->fetch();
        $result = $this->queryTable(  'public.barramento_placamae ' . $tabela->getcondicao(), 
                                         'id_barramento_placamae as principal ,
                                          id_barramento,
                                          id_placa_mae'
                                       );
        $resultado = array(
            'page' => $tabela->getPagina(),
          'total' => $tabela->calculaPaginacao($nLinhas['num']),
            'records' => $nLinhas['num']
        );
        foreach ($result as $linhaBanco) {
            $row = array();
            $barramentoPlacamae = $this->setDados($linhaBanco);
            $row['id'] = $barramentoPlacamae->getidBarramentoPlacamae();
            $row['cell'] = $barramentoPlacamae->getArrayJson();
            $dados[] = $row;
       }
        $resultado['rows'] = $dados;
        return $resultado;
    }

     /**
     * Método que retorna um objeto do tipo BarramentoPlacamae
     * sendo determinado pelo identifcador do mesmo na tabela
     *
     * @param integer $id - Identificador do dado
     * @return BarramentoPlacamae - Objeto data transfer
     */
    public function getByID($id) {
        $barramentoPlacamae = new BarramentoPlacamae();
        $consulta = $this->queryTable($barramentoPlacamae->getTable(),
                                         'id_barramento_placamae as principal ,
                                          id_barramento,
                                          id_placa_mae',
                        'id_barramento_placamae ='. $id );
        if ($consulta) {
            $barramentoPlacamae = $this->setDados($consulta->fetch());
            return $barramentoPlacamae;
        } else {
             throw new EntradaDeDadosException();
        }
     }
     /**
     * Método que retorna um array de objetos BarramentoPlacamae
     * sendo determinado pelo parâmetro $condicao
     *
     * @param String $condicao - Condição da consulta
     * @return Array de objetos BarramentoPlacamae
     */
    public function getLista($condicao = false)
    {
        $dados = array();
        $result = $this->queryTable(  'public.barramento_placamae ', 
                                         'id_barramento_placamae as principal ,
                                          id_barramento,
                                          id_placa_mae',
            $condicao);
        foreach ($result as $linhaBanco) {
            $barramentoPlacamae = $this->setDados($linhaBanco);
            $dados[] = $barramentoPlacamae;
       }
        return $dados;
    }

    /**
     * Método Private que retorna um objeto setado BarramentoPlacamae
     * com objetivo de servir as funções getTabela, getLista e getBarramentoPlacamae
     *
     * @param array $linha
     * @return objeto BarramentoPlacamae
     */
    private function setDados($dados)
    {
        $barramentoPlacamae = new BarramentoPlacamae();
        $barramentoPlacamae->setIdBarramentoPlacamae($dados['principal']);
        $barramentoPlacamae->setIdBarramento($dados['id_barramento']);
        $barramentoPlacamae->setIdPlacaMae($dados['id_placa_mae']);
        return $barramentoPlacamae;
    }

    /**
     * Método que insere um objeto do tipo BarramentoPlacamae
     * na tabela do banco de dados
     *
     * @param BarramentoPlacamae Objeto data transfer
     */
    public function inserirEmTransacao(BarramentoPlacamae $obj)
    {
        $this->DB()->begin();
        if ($this->save($obj)) {
            $sequencia = 'public.barramento_placamae_id_barramento_placamae_seq';
        $id = $this->DB()->lastInsertId($sequencia);
        $this->DB()->commit();
        return $id;
    } else {
        return false;
    }
   }
}