<?php

/**
 * Classe de modelo referente ao objeto Fonte para 
 * a manutenção dos dados no sistema 
 *
 * @package modulos.
 * @author Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0 - 25-07-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class FonteDAO extends AbstractDAO 
{

    /**
    * Construtor da classe FonteDAO esse metodo  
    * instancia o Modelo padrão conectando o mesmo ao banco de dados
    *
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Método que retorna um array com a tabela dos dados de Fonte
     *
     * @return Array tabela de dados
     */
    public function getTabela(TabelaConsulta $tabela)
    {
        $dados = array();
        $nLinhasCon = $this->queryTable('public.fonte', 'count(id_fonte) as num');
        $nLinhas = $nLinhasCon->fetch();
        $result = $this->queryTable(  'public.fonte ' . $tabela->getcondicao(), 
                                         'id_fonte as principal ,
                                          nome,
                                          potencia,
                                          descricao,
                                          computador'
                                       );
        $resultado = array(
            'page' => $tabela->getPagina(),
          'total' => $tabela->calculaPaginacao($nLinhas['num']),
            'records' => $nLinhas['num']
        );
        foreach ($result as $linhaBanco) {
            $row = array();
            $fonte = $this->setDados($linhaBanco);
            $row['id'] = $fonte->getidFonte();
            $row['cell'] = $fonte->getArrayJson();
            $dados[] = $row;
       }
        $resultado['rows'] = $dados;
        return $resultado;
    }

     /**
     * Método que retorna um objeto do tipo Fonte
     * sendo determinado pelo identifcador do mesmo na tabela
     *
     * @param integer $id - Identificador do dado
     * @return Fonte - Objeto data transfer
     */
    public function getByID($id) {
        $fonte = new Fonte();
        $consulta = $this->queryTable($fonte->getTable(),
                                         'id_fonte as principal ,
                                          nome,
                                          potencia,
                                          descricao,
                                          computador',
                        'id_fonte ='. $id );
        if ($consulta) {
            $fonte = $this->setDados($consulta->fetch());
            return $fonte;
        } else {
             throw new EntradaDeDadosException();
        }
     }
     
     public function getByComputerID($id) {
     	$fonte = new Fonte();
     	$consulta = $this->queryTable($fonte->getTable(),
     			'id_fonte as principal ,
                                          nome,
                                          potencia,
                                          descricao,
                                          computador',
     			'computador ='. $id );
     	if ($consulta) {
     		$fonte = $this->setDados($consulta->fetch());
     		return $fonte;
     	} else {
     		throw new EntradaDeDadosException();
     	}
     }
     /**
     * Método que retorna um array de objetos Fonte
     * sendo determinado pelo parâmetro $condicao
     *
     * @param String $condicao - Condição da consulta
     * @return Array de objetos Fonte
     */
    public function getLista($condicao = false, $order = false)
    {
        $dados = array();
        $result = $this->queryTable(  'public.fonte ', 
                                         'id_fonte as principal ,
                                          nome,
                                          potencia,
                                          descricao,
                                          computador',
            $condicao, $order);
        foreach ($result as $linhaBanco) {
            $fonte = $this->setDados($linhaBanco);
            $dados[] = $fonte;
       }
        return $dados;
    }

    
    public function getAll()
    {
        $dados = array();
        $result = $this->queryTable(  'public.fonte ',
            'id_fonte as principal ,
                                          nome,
                                          potencia,
                                          descricao,
                                          computador');
        foreach ($result as $linhaBanco) {
            $fonte = $this->setDados($linhaBanco);
            $dados[] = $fonte;
        }
        return $dados;
    }
    
    /**
     * Método Private que retorna um objeto setado Fonte
     * com objetivo de servir as funções getTabela, getLista e getFonte
     *
     * @param array $linha
     * @return objeto Fonte
     */
    private function setDados($dados)
    {
        $fonte = new Fonte();
        $fonte->setIdFonte($dados['principal']);
        $fonte->setNome($dados['nome']);
        $fonte->setPotencia($dados['potencia']);
        $fonte->setDescricao($dados['descricao']);
        $fonte->setComputador($dados['computador']);
        return $fonte;
    }

    /**
     * Método que insere um objeto do tipo Fonte
     * na tabela do banco de dados
     *
     * @param Fonte Objeto data transfer
     */
    public function inserirEmTransacao(Fonte $obj)
    {
        $this->DB()->begin();
        if ($this->save($obj)) {
            $sequencia = 'public.fonte_id_fonte_seq';
        $id = $this->DB()->lastInsertId($sequencia);
        $this->DB()->commit();
        return $id;
    } else {
        return false;
    }
   }
}