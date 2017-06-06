<?php

/**
 * Classe de modelo referente ao objeto Computador para 
 * a manutenção dos dados no sistema 
 *
 * @package modulos.
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0.0 - 06-06-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class ComputadorDAO extends AbstractDAO 
{

    /**
    * Construtor da classe ComputadorDAO esse metodo  
    * instancia o Modelo padrão conectando o mesmo ao banco de dados
    *
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Método que retorna um array com a tabela dos dados de Computador
     *
     * @return Array tabela de dados
     */
    public function getTabela(TabelaConsulta $tabela)
    {
        $dados = array();
        $nLinhasCon = $this->queryTable('public.computador', 'count(id_computador) as num');
        $nLinhas = $nLinhasCon->fetch();
        $result = $this->queryTable(  'public.computador ' . $tabela->getcondicao(), 
                                         'id_computador as principal ,
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
            $computador = $this->setDados($linhaBanco);
            $row['id'] = $computador->getidComputador();
            $row['cell'] = $computador->getArrayJson();
            $dados[] = $row;
       }
        $resultado['rows'] = $dados;
        return $resultado;
    }

     /**
     * Método que retorna um objeto do tipo Computador
     * sendo determinado pelo identifcador do mesmo na tabela
     *
     * @param integer $id - Identificador do dado
     * @return Computador - Objeto data transfer
     */
    public function getByID($id) {
        $computador = new Computador();
        $consulta = $this->queryTable($computador->getTable(),
                                         'id_computador as principal ,
                                          nome,
                                          descricao',
                        'id_computador ='. $id );
        if ($consulta) {
            $computador = $this->setDados($consulta->fetch());
            return $computador;
        } else {
             throw new EntradaDeDadosException();
        }
     }
     /**
     * Método que retorna um array de objetos Computador
     * sendo determinado pelo parâmetro $condicao
     *
     * @param String $condicao - Condição da consulta
     * @return Array de objetos Computador
     */
    public function getLista($condicao = false)
    {
        $dados = array();
        $result = $this->queryTable(  'public.computador ', 
                                         'id_computador as principal ,
                                          nome,
                                          descricao',
            $condicao);
        foreach ($result as $linhaBanco) {
            $computador = $this->setDados($linhaBanco);
            $dados[] = $computador;
       }
        return $dados;
    }

    /**
     * Método Private que retorna um objeto setado Computador
     * com objetivo de servir as funções getTabela, getLista e getComputador
     *
     * @param array $linha
     * @return objeto Computador
     */
    private function setDados($dados)
    {
        $computador = new Computador();
        $computador->setIdComputador($dados['principal']);
        $computador->setNome($dados['nome']);
        $computador->setDescricao($dados['descricao']);
        return $computador;
    }

    /**
     * Método que insere um objeto do tipo Computador
     * na tabela do banco de dados
     *
     * @param Computador Objeto data transfer
     */
    public function inserirEmTransacao(Computador $obj)
    {
        $this->DB()->begin();
        if ($this->save($obj)) {
            $sequencia = 'public.computador_id_computador_seq';
        $id = $this->DB()->lastInsertId($sequencia);
        $this->DB()->commit();
        return $id;
    } else {
        return false;
    }
   }
}