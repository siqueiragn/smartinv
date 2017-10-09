<?php

/**
 * Classe de modelo referente ao objeto Memoria para 
 * a manutenção dos dados no sistema 
 *
 * @package modulos.
 * @author Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0 - 06-10-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class MemoriaDAO extends AbstractDAO 
{

    /**
    * Construtor da classe MemoriaDAO esse metodo  
    * instancia o Modelo padrão conectando o mesmo ao banco de dados
    *
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Método que retorna um array com a tabela dos dados de Memoria
     *
     * @return Array tabela de dados
     */
    public function getTabela(TabelaConsulta $tabela)
    {
        $dados = array();
        $nLinhasCon = $this->queryTable('public.memoria', 'count(id_memoria) as num');
        $nLinhas = $nLinhasCon->fetch();
        $result = $this->queryTable(  'public.memoria ' . $tabela->getcondicao(), 
                                         'id_memoria as principal ,
                                          nome,
                                          frequencia,
                                          capacidade,
                                          tipo,
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
            $memoria = $this->setDados($linhaBanco);
            $row['id'] = $memoria->getidMemoria();
            $row['cell'] = $memoria->getArrayJson();
            $dados[] = $row;
       }
        $resultado['rows'] = $dados;
        return $resultado;
    }

     /**
     * Método que retorna um objeto do tipo Memoria
     * sendo determinado pelo identifcador do mesmo na tabela
     *
     * @param integer $id - Identificador do dado
     * @return Memoria - Objeto data transfer
     */
    public function getByID($id) {
        $memoria = new Memoria();
        $consulta = $this->queryTable($memoria->getTable(),
                                         'id_memoria as principal ,
                                          nome,
                                          frequencia,
                                          capacidade,
                                          tipo,
                                          descricao,
                                          computador',
                        'id_memoria ='. $id );
        if ($consulta) {
            $memoria = $this->setDados($consulta->fetch());
            return $memoria;
        } else {
             throw new EntradaDeDadosException();
        }
     }


public function getByComputerID($id) {
        $memoria = new Memoria();
        $consulta = $this->queryTable($memoria->getTable(),
                                         'id_memoria as principal ,
                                          nome,
                                          frequencia,
                                          capacidade,
                                          tipo,
                                          descricao,
                                          computador',
                        'computador ='. $id );
        if ($consulta) {
            $memoria = $this->setDados($consulta->fetch());
            return $memoria;
        } else {
             throw new EntradaDeDadosException();
        }
     }

     /**
     * Método que retorna um array de objetos Memoria
     * sendo determinado pelo parâmetro $condicao
     *
     * @param String $condicao - Condição da consulta
     * @return Array de objetos Memoria
     */
    public function getLista($condicao = false)
    {
        $dados = array();
        $result = $this->queryTable(  'public.memoria ', 
                                         'id_memoria as principal ,
                                          nome,
                                          frequencia,
                                          capacidade,
                                          tipo,
                                          descricao,
                                          computador',
            $condicao);
        foreach ($result as $linhaBanco) {
            $memoria = $this->setDados($linhaBanco);
            $dados[] = $memoria;
       }
        return $dados;
    }

    /**
     * Método Private que retorna um objeto setado Memoria
     * com objetivo de servir as funções getTabela, getLista e getMemoria
     *
     * @param array $linha
     * @return objeto Memoria
     */
    private function setDados($dados)
    {
        $memoria = new Memoria();
        $memoria->setIdMemoria($dados['principal']);
        $memoria->setNome($dados['nome']);
        $memoria->setFrequencia($dados['frequencia']);
        $memoria->setCapacidade($dados['capacidade']);
        $memoria->setTipo($dados['tipo']);
        $memoria->setDescricao($dados['descricao']);
        $memoria->setComputador($dados['computador']);
        return $memoria;
    }

    /**
     * Método que insere um objeto do tipo Memoria
     * na tabela do banco de dados
     *
     * @param Memoria Objeto data transfer
     */
    public function inserirEmTransacao(Memoria $obj)
    {
        $this->DB()->begin();
        if ($this->save($obj)) {
            $sequencia = 'public.memoria_id_memoria_seq';
        $id = $this->DB()->lastInsertId($sequencia);
        $this->DB()->commit();
        return $id;
    } else {
        return false;
    }
   }
}