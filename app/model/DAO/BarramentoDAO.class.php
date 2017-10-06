<?php

/**
 * Classe de modelo referente ao objeto Barramento para 
 * a manutenção dos dados no sistema 
 *
 * @package modulos.
 * @author Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0 - 06-10-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class BarramentoDAO extends AbstractDAO 
{

    /**
    * Construtor da classe BarramentoDAO esse metodo  
    * instancia o Modelo padrão conectando o mesmo ao banco de dados
    *
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Método que retorna um array com a tabela dos dados de Barramento
     *
     * @return Array tabela de dados
     */
    public function getTabela(TabelaConsulta $tabela)
    {
        $dados = array();
        $nLinhasCon = $this->queryTable('public.barramento', 'count(id_barramento) as num');
        $nLinhas = $nLinhasCon->fetch();
        $result = $this->queryTable(  'public.barramento ' . $tabela->getcondicao(), 
                                         'id_barramento as principal ,
                                          nome,
                                          descricao'
                                       );
        $resultado = array(
            'page' => $tabela->getPagina(),
          'total' => $tabela->calculaPaginacao($nLinhas['num']),
            'records' => $nLinhas['num']
        );
        foreach ($result as $linhaBanco) {
            $row = array();
            $barramento = $this->setDados($linhaBanco);
            $row['id'] = $barramento->getidBarramento();
            $row['cell'] = $barramento->getArrayJson();
            $dados[] = $row;
       }
        $resultado['rows'] = $dados;
        return $resultado;
    }

     /**
     * Método que retorna um objeto do tipo Barramento
     * sendo determinado pelo identifcador do mesmo na tabela
     *
     * @param integer $id - Identificador do dado
     * @return Barramento - Objeto data transfer
     */
    public function getByID($id) {
        $barramento = new Barramento();
        $consulta = $this->queryTable($barramento->getTable(),
                                         'id_barramento as principal ,
                                          nome,
                                          descricao',
                        'id_barramento ='. $id );
        if ($consulta) {
            $barramento = $this->setDados($consulta->fetch());
            return $barramento;
        } else {
             throw new EntradaDeDadosException();
        }
     }
     /**
     * Método que retorna um array de objetos Barramento
     * sendo determinado pelo parâmetro $condicao
     *
     * @param String $condicao - Condição da consulta
     * @return Array de objetos Barramento
     */
    public function getLista($condicao = false)
    {
        $dados = array();
        $result = $this->queryTable(  'public.barramento ', 
                                         'id_barramento as principal ,
                                          nome,
                                          descricao',
            $condicao);
        foreach ($result as $linhaBanco) {
            $barramento = $this->setDados($linhaBanco);
            $dados[] = $barramento;
       }
        return $dados;
    }

    /**
     * Método Private que retorna um objeto setado Barramento
     * com objetivo de servir as funções getTabela, getLista e getBarramento
     *
     * @param array $linha
     * @return objeto Barramento
     */
    private function setDados($dados)
    {
        $barramento = new Barramento();
        $barramento->setIdBarramento($dados['principal']);
        $barramento->setNome($dados['nome']);
        $barramento->setDescricao($dados['descricao']);
        return $barramento;
    }

    /**
     * Método que insere um objeto do tipo Barramento
     * na tabela do banco de dados
     *
     * @param Barramento Objeto data transfer
     */
    public function inserirEmTransacao(Barramento $obj)
    {
        $this->DB()->begin();
        if ($this->save($obj)) {
            $sequencia = 'public.barramento_id_barramento_seq';
        $id = $this->DB()->lastInsertId($sequencia);
        $this->DB()->commit();
        return $id;
    } else {
        return false;
    }
   }
}