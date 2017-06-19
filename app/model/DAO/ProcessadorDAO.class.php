<?php

/**
 * Classe de modelo referente ao objeto Processador para 
 * a manutenção dos dados no sistema 
 *
 * @package modulos.
 * @author Gabriel <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0 - 13-06-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class ProcessadorDAO extends AbstractDAO 
{

    /**
    * Construtor da classe ProcessadorDAO esse metodo  
    * instancia o Modelo padrão conectando o mesmo ao banco de dados
    *
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Método que retorna um array com a tabela dos dados de Processador
     *
     * @return Array tabela de dados
     */
    public function getTabela(TabelaConsulta $tabela)
    {
        $dados = array();
        $nLinhasCon = $this->queryTable('public.processador', 'count(nome) as num');
        $nLinhas = $nLinhasCon->fetch();
        $result = $this->queryTable(  'public.processador ' . $tabela->getcondicao(), 
                                         'nome as principal ,
                                          id_processador,
                                          frequencia,
                                          descricao,
                                          socket,
                                          computador'
                                       );
        $resultado = array(
            'page' => $tabela->getPagina(),
          'total' => $tabela->calculaPaginacao($nLinhas['num']),
            'records' => $nLinhas['num']
        );
        foreach ($result as $linhaBanco) {
            $row = array();
            $processador = $this->setDados($linhaBanco);
            $row['id'] = $processador->getnome();
            $row['cell'] = $processador->getArrayJson();
            $dados[] = $row;
       }
        $resultado['rows'] = $dados;
        return $resultado;
    }

     /**
     * Método que retorna um objeto do tipo Processador
     * sendo determinado pelo identifcador do mesmo na tabela
     *
     * @param integer $id - Identificador do dado
     * @return Processador - Objeto data transfer
     */
    public function getByID($id) {
        $processador = new Processador();
        $consulta = $this->queryTable($processador->getTable(),
                                         'nome as principal ,
                                          id_processador,
                                          frequencia,
                                          descricao,
                                          socket,
                                          computador',
                        'id_processador ='. $id );
        if ($consulta) {
            $processador = $this->setDados($consulta->fetch());
            return $processador;
        } else {
             throw new EntradaDeDadosException();
        }
     }
     /**
     * Método que retorna um array de objetos Processador
     * sendo determinado pelo parâmetro $condicao
     *
     * @param String $condicao - Condição da consulta
     * @return Array de objetos Processador
     */
    public function getLista($condicao = false)
    {
        $dados = array();
        $result = $this->queryTable(  'public.processador ', 
                                         'nome as principal ,
                                          id_processador,
                                          frequencia,
                                          descricao,
                                          socket,
                                          computador',
            $condicao);
        foreach ($result as $linhaBanco) {
            $processador = $this->setDados($linhaBanco);
            $dados[] = $processador;
       }
        return $dados;
    }

    /**
     * Método Private que retorna um objeto setado Processador
     * com objetivo de servir as funções getTabela, getLista e getProcessador
     *
     * @param array $linha
     * @return objeto Processador
     */
    private function setDados($dados)
    {
        $processador = new Processador();
        $processador->setNome($dados['principal']);
        $processador->setIdProcessador($dados['id_processador']);
        $processador->setFrequencia($dados['frequencia']);
        $processador->setDescricao($dados['descricao']);
        $processador->setSocket($dados['socket']);
        $processador->setComputador($dados['computador']);
        return $processador;
    }

    /**
     * Método que insere um objeto do tipo Processador
     * na tabela do banco de dados
     *
     * @param Processador Objeto data transfer
     */
    public function inserirEmTransacao(Processador $obj)
    {
        $this->DB()->begin();
        if ($this->save($obj)) {
            $sequencia = 'public.processador_id_processador_seq';
        $id = $this->DB()->lastInsertId($sequencia);
        $this->DB()->commit();
        return $id;
    } else {
        return false;
    }
   }
}