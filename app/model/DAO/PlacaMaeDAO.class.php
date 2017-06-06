<?php

/**
 * Classe de modelo referente ao objeto PlacaMae para 
 * a manutenção dos dados no sistema 
 *
 * @package modulos.
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0.0 - 06-06-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class PlacaMaeDAO extends AbstractDAO 
{

    /**
    * Construtor da classe PlacaMaeDAO esse metodo  
    * instancia o Modelo padrão conectando o mesmo ao banco de dados
    *
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Método que retorna um array com a tabela dos dados de Placa mae
     *
     * @return Array tabela de dados
     */
    public function getTabela(TabelaConsulta $tabela)
    {
        $dados = array();
        $nLinhasCon = $this->queryTable('public.placa_mae', 'count(id_placa_mae) as num');
        $nLinhas = $nLinhasCon->fetch();
        $result = $this->queryTable(  'public.placa_mae ' . $tabela->getcondicao(), 
                                         'id_placa_mae as principal ,
                                          nome,
                                          socket,
                                          portas_usb,
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
            $placaMae = $this->setDados($linhaBanco);
            $row['id'] = $placaMae->getidPlacaMae();
            $row['cell'] = $placaMae->getArrayJson();
            $dados[] = $row;
       }
        $resultado['rows'] = $dados;
        return $resultado;
    }

     /**
     * Método que retorna um objeto do tipo PlacaMae
     * sendo determinado pelo identifcador do mesmo na tabela
     *
     * @param integer $id - Identificador do dado
     * @return PlacaMae - Objeto data transfer
     */
    public function getByID($id) {
        $placaMae = new PlacaMae();
        $consulta = $this->queryTable($placaMae->getTable(),
                                         'id_placa_mae as principal ,
                                          nome,
                                          socket,
                                          portas_usb,
                                          descricao,
                                          computador',
                        'id_placa_mae ='. $id );
        if ($consulta) {
            $placaMae = $this->setDados($consulta->fetch());
            return $placaMae;
        } else {
             throw new EntradaDeDadosException();
        }
     }
     /**
     * Método que retorna um array de objetos PlacaMae
     * sendo determinado pelo parâmetro $condicao
     *
     * @param String $condicao - Condição da consulta
     * @return Array de objetos PlacaMae
     */
    public function getLista($condicao = false)
    {
        $dados = array();
        $result = $this->queryTable(  'public.placa_mae ', 
                                         'id_placa_mae as principal ,
                                          nome,
                                          socket,
                                          portas_usb,
                                          descricao,
                                          computador',
            $condicao);
        foreach ($result as $linhaBanco) {
            $placaMae = $this->setDados($linhaBanco);
            $dados[] = $placaMae;
       }
        return $dados;
    }

    /**
     * Método Private que retorna um objeto setado PlacaMae
     * com objetivo de servir as funções getTabela, getLista e getPlacaMae
     *
     * @param array $linha
     * @return objeto PlacaMae
     */
    private function setDados($dados)
    {
        $placaMae = new PlacaMae();
        $placaMae->setIdPlacaMae($dados['principal']);
        $placaMae->setNome($dados['nome']);
        $placaMae->setSocket($dados['socket']);
        $placaMae->setPortasUsb($dados['portas_usb']);
        $placaMae->setDescricao($dados['descricao']);
        $placaMae->setComputador($dados['computador']);
        return $placaMae;
    }

    /**
     * Método que insere um objeto do tipo PlacaMae
     * na tabela do banco de dados
     *
     * @param PlacaMae Objeto data transfer
     */
    public function inserirEmTransacao(PlacaMae $obj)
    {
        $this->DB()->begin();
        if ($this->save($obj)) {
            $sequencia = 'public.placa_mae_id_placa_mae_seq';
        $id = $this->DB()->lastInsertId($sequencia);
        $this->DB()->commit();
        return $id;
    } else {
        return false;
    }
   }
}