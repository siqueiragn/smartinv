<?php

/**
 * Classe de modelo referente ao objeto DiscoRigido para 
 * a manutenção dos dados no sistema 
 *
 * @package modulos.
 * @author Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0 - 28-07-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class DiscoRigidoDAO extends AbstractDAO 
{

    /**
    * Construtor da classe DiscoRigidoDAO esse metodo  
    * instancia o Modelo padrão conectando o mesmo ao banco de dados
    *
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Método que retorna um array com a tabela dos dados de Disco rigido
     *
     * @return Array tabela de dados
     */
    public function getTabela(TabelaConsulta $tabela)
    {
        $dados = array();
        $nLinhasCon = $this->queryTable('public.disco_rigido', 'count(id_disco_rigido) as num');
        $nLinhas = $nLinhasCon->fetch();
        $result = $this->queryTable(  'public.disco_rigido ' . $tabela->getcondicao(), 
                                         'id_disco_rigido as principal ,
                                          nome,
                                          capacidade,
                                          v_cache,
                                          rpm,
                                          descricao,
                                          barramento,
                                          computador'
                                       );
        $resultado = array(
            'page' => $tabela->getPagina(),
          'total' => $tabela->calculaPaginacao($nLinhas['num']),
            'records' => $nLinhas['num']
        );
        foreach ($result as $linhaBanco) {
            $row = array();
            $discoRigido = $this->setDados($linhaBanco);
            $row['id'] = $discoRigido->getidDiscoRigido();
            $row['cell'] = $discoRigido->getArrayJson();
            $dados[] = $row;
       }
        $resultado['rows'] = $dados;
        return $resultado;
    }

     /**
     * Método que retorna um objeto do tipo DiscoRigido
     * sendo determinado pelo identifcador do mesmo na tabela
     *
     * @param integer $id - Identificador do dado
     * @return DiscoRigido - Objeto data transfer
     */
    public function getByID($id) {
        $discoRigido = new DiscoRigido();
        $consulta = $this->queryTable($discoRigido->getTable(),
                                         'id_disco_rigido as principal ,
                                          nome,
                                          capacidade,
                                          v_cache,
                                          rpm,
                                          descricao,
                                          barramento,
                                          computador',
                        'id_disco_rigido ='. $id );
        if ($consulta) {
            $discoRigido = $this->setDados($consulta->fetch());
            return $discoRigido;
        } else {
             throw new EntradaDeDadosException();
        }
     }
	 
	 public function getByComputerID($id) {
        $discoRigido = new DiscoRigido();
        $consulta = $this->queryTable($discoRigido->getTable(),
                                         'id_disco_rigido as principal ,
                                          nome,
                                          capacidade,
                                          v_cache,
                                          rpm,
                                          descricao,
                                          barramento,
                                          computador',
                        'computador ='. $id );
        if ($consulta) {
            $discoRigido = $this->setDados($consulta->fetch());
            return $discoRigido;
        } else {
             throw new EntradaDeDadosException();
        }
     }
     /**
     * Método que retorna um array de objetos DiscoRigido
     * sendo determinado pelo parâmetro $condicao
     *
     * @param String $condicao - Condição da consulta
     * @return Array de objetos DiscoRigido
     */
    public function getLista($condicao = false, $order = false)
    {
        $dados = array();
        $result = $this->queryTable(  'public.disco_rigido ', 
                                         'id_disco_rigido as principal ,
                                          nome,
                                          capacidade,
                                          v_cache,
                                          rpm,
                                          descricao,
                                          barramento,
                                          computador',
            $condicao, $order);
        foreach ($result as $linhaBanco) {
            $discoRigido = $this->setDados($linhaBanco);
            $dados[] = $discoRigido;
       }
        return $dados;
    }
    
    
    public function getAll()
    {
        $dados = array();
        $result = $this->queryTable(  'public.disco_rigido ',
            'id_disco_rigido as principal ,
                                          nome,
                                          capacidade,
                                          v_cache,
                                          rpm,
                                          descricao,
                                          barramento,
                                          computador');
        foreach ($result as $linhaBanco) {
            $discoRigido = $this->setDados($linhaBanco);
            $dados[] = $discoRigido;
        }
        return $dados;
    }

    /**
     * Método Private que retorna um objeto setado DiscoRigido
     * com objetivo de servir as funções getTabela, getLista e getDiscoRigido
     *
     * @param array $linha
     * @return objeto DiscoRigido
     */
    private function setDados($dados)
    {
        $discoRigido = new DiscoRigido();
        $discoRigido->setIdDiscoRigido($dados['principal']);
        $discoRigido->setNome($dados['nome']);
        $discoRigido->setCapacidade($dados['capacidade']);
        $discoRigido->setVCache($dados['v_cache']);
        $discoRigido->setRpm($dados['rpm']);
        $discoRigido->setDescricao($dados['descricao']);
        $discoRigido->setBarramento($dados['barramento']);
        $discoRigido->setComputador($dados['computador']);
        return $discoRigido;
    }

    /**
     * Método que insere um objeto do tipo DiscoRigido
     * na tabela do banco de dados
     *
     * @param DiscoRigido Objeto data transfer
     */
    public function inserirEmTransacao(DiscoRigido $obj)
    {
        $this->DB()->begin();
        if ($this->save($obj)) {
            $sequencia = 'public.disco_rigido_id_disco_rigido_seq';
        $id = $this->DB()->lastInsertId($sequencia);
        $this->DB()->commit();
        return $id;
    } else {
        return false;
    }
   }
}