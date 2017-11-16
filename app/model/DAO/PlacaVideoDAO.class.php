<?php

/**
 * Classe de modelo referente ao objeto PlacaVideo para 
 * a manutenção dos dados no sistema 
 *
 * @package modulos.
 * @author Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0 - 28-07-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class PlacaVideoDAO extends AbstractDAO 
{

    /**
    * Construtor da classe PlacaVideoDAO esse metodo  
    * instancia o Modelo padrão conectando o mesmo ao banco de dados
    *
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Método que retorna um array com a tabela dos dados de Placa video
     *
     * @return Array tabela de dados
     */
    public function getTabela(TabelaConsulta $tabela)
    {
        $dados = array();
        $nLinhasCon = $this->queryTable('public.placa_video', 'count(id_placa_video) as num');
        $nLinhas = $nLinhasCon->fetch();
        $result = $this->queryTable(  'public.placa_video ' . $tabela->getcondicao(), 
                                         'id_placa_video as principal ,
                                          nome,
                                          frequencia,
                                          memoria,
                                          tipo,
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
            $placaVideo = $this->setDados($linhaBanco);
            $row['id'] = $placaVideo->getidPlacaVideo();
            $row['cell'] = $placaVideo->getArrayJson();
            $dados[] = $row;
       }
        $resultado['rows'] = $dados;
        return $resultado;
    }

     /**
     * Método que retorna um objeto do tipo PlacaVideo
     * sendo determinado pelo identifcador do mesmo na tabela
     *
     * @param integer $id - Identificador do dado
     * @return PlacaVideo - Objeto data transfer
     */
    public function getByID($id) {
        $placaVideo = new PlacaVideo();
        $consulta = $this->queryTable($placaVideo->getTable(),
                                         'id_placa_video as principal ,
                                          nome,
                                          frequencia,
                                          memoria,
                                          tipo,
                                          descricao,
                                          barramento,
                                          computador',
                        'id_placa_video ='. $id );
        if ($consulta) {
            $placaVideo = $this->setDados($consulta->fetch());
            return $placaVideo;
        } else {
             throw new EntradaDeDadosException();
        }
     }
     
     public function getByComputerID($id) {
     	$placaVideo = new PlacaVideo();
     	$consulta = $this->queryTable($placaVideo->getTable(),
     			'id_placa_video as principal ,
                                          nome,
                                          frequencia,
                                          memoria,
                                          tipo,
                                          descricao,
                                          barramento,
                                          computador',
     			'computador ='. $id );
     	if ($consulta) {
     		$placaVideo = $this->setDados($consulta->fetch());
     		return $placaVideo;
     	} else {
     		throw new EntradaDeDadosException();
     	}
     }
     /**
     * Método que retorna um array de objetos PlacaVideo
     * sendo determinado pelo parâmetro $condicao
     *
     * @param String $condicao - Condição da consulta
     * @return Array de objetos PlacaVideo
     */
    public function getLista($condicao = false)
    {
        $dados = array();
        $result = $this->queryTable(  'public.placa_video ', 
                                         'id_placa_video as principal ,
                                          nome,
                                          frequencia,
                                          memoria,
                                          tipo,
                                          descricao,
                                          barramento,
                                          computador',
            $condicao);
        foreach ($result as $linhaBanco) {
            $placaVideo = $this->setDados($linhaBanco);
            $dados[] = $placaVideo;
       }
        return $dados;
    }

    public function getAll()
    {
        $dados = array();
        $result = $this->queryTable(  'public.placa_video ',
            'id_placa_video as principal ,
                                          nome,
                                          frequencia,
                                          memoria,
                                          tipo,
                                          descricao,
                                          barramento,
                                          computador');
        foreach ($result as $linhaBanco) {
            $placaVideo = $this->setDados($linhaBanco);
            $dados[] = $placaVideo;
        }
        return $dados;
    }
    
    
    
    /**
     * Método Private que retorna um objeto setado PlacaVideo
     * com objetivo de servir as funções getTabela, getLista e getPlacaVideo
     *
     * @param array $linha
     * @return objeto PlacaVideo
     */
    private function setDados($dados)
    {
        $placaVideo = new PlacaVideo();
        $placaVideo->setIdPlacaVideo($dados['principal']);
        $placaVideo->setNome($dados['nome']);
        $placaVideo->setFrequencia($dados['frequencia']);
        $placaVideo->setMemoria($dados['memoria']);
        $placaVideo->setTipo($dados['tipo']);
        $placaVideo->setDescricao($dados['descricao']);
        $placaVideo->setBarramento($dados['barramento']);
        $placaVideo->setComputador($dados['computador']);
        return $placaVideo;
    }

    /**
     * Método que insere um objeto do tipo PlacaVideo
     * na tabela do banco de dados
     *
     * @param PlacaVideo Objeto data transfer
     */
    public function inserirEmTransacao(PlacaVideo $obj)
    {
        $this->DB()->begin();
        if ($this->save($obj)) {
            $sequencia = 'public.placa_video_id_placa_video_seq';
        $id = $this->DB()->lastInsertId($sequencia);
        $this->DB()->commit();
        return $id;
    } else {
        return false;
    }
   }
}