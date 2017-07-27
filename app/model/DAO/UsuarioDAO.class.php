<?php

/**
 * Classe de modelo referente ao objeto Usuario para 
 * a manutenção dos dados no sistema 
 *
 * @package modulos.
 * @author Gabriel Nunes de Siqueira <gabrielndesiqueira@hotmail.com>
 * @version 1.0.0 - 25-07-2017(Gerado automaticamente - GC - 1.0 02/11/2015)
 */

class UsuarioDAO extends AbstractDAO 
{

    /**
    * Construtor da classe UsuarioDAO esse metodo  
    * instancia o Modelo padrão conectando o mesmo ao banco de dados
    *
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Método que retorna um array com a tabela dos dados de Usuário
     *
     * @return Array tabela de dados
     */
    public function getTabela(TabelaConsulta $tabela)
    {
        $dados = array();
        $nLinhasCon = $this->queryTable('public.usuario', 'count(id_usuario) as num');
        $nLinhas = $nLinhasCon->fetch();
        $result = $this->queryTable(  'public.usuario ' . $tabela->getcondicao(), 
                                         'id_usuario as principal ,
                                          email,
                                          password'
                                       );
        $resultado = array(
            'page' => $tabela->getPagina(),
          'total' => $tabela->calculaPaginacao($nLinhas['num']),
            'records' => $nLinhas['num']
        );
        foreach ($result as $linhaBanco) {
            $row = array();
            $usuario = $this->setDados($linhaBanco);
            $row['id'] = $usuario->getidUsuario();
            $row['cell'] = $usuario->getArrayJson();
            $dados[] = $row;
       }
        $resultado['rows'] = $dados;
        return $resultado;
    }

     /**
     * Método que retorna um objeto do tipo Usuario
     * sendo determinado pelo identifcador do mesmo na tabela
     *
     * @param integer $id - Identificador do dado
     * @return Usuario - Objeto data transfer
     */
    public function getByID($id) {
        $usuario = new Usuario();
        $consulta = $this->queryTable($usuario->getTable(),
                                         'id_usuario as principal ,
                                          email,
                                          password',
                        'id_usuario ='. $id );
        if ($consulta) {
            $usuario = $this->setDados($consulta->fetch());
            return $usuario;
        } else {
             throw new EntradaDeDadosException();
        }
     }
     /**
     * Método que retorna um array de objetos Usuario
     * sendo determinado pelo parâmetro $condicao
     *
     * @param String $condicao - Condição da consulta
     * @return Array de objetos Usuario
     */
    public function getLista($condicao = false)
    {
        $dados = array();
        $result = $this->queryTable(  'public.usuario ', 
                                         'id_usuario as principal ,
                                          email,
                                          password',
            $condicao);
        foreach ($result as $linhaBanco) {
            $usuario = $this->setDados($linhaBanco);
            $dados[] = $usuario;
       }
        return $dados;
    }

    /**
     * Método Private que retorna um objeto setado Usuario
     * com objetivo de servir as funções getTabela, getLista e getUsuario
     *
     * @param array $linha
     * @return objeto Usuario
     */
    private function setDados($dados)
    {
        $usuario = new Usuario();
        $usuario->setIdUsuario($dados['principal']);
        $usuario->setEmail($dados['email']);
        $usuario->setPassword($dados['password']);
        return $usuario;
    }

    /**
     * Método que insere um objeto do tipo Usuario
     * na tabela do banco de dados
     *
     * @param Usuario Objeto data transfer
     */
    public function inserirEmTransacao(Usuario $obj)
    {
        $this->DB()->begin();
        if ($this->save($obj)) {
            $sequencia = 'public.usuario_id_usuario_seq';
        $id = $this->DB()->lastInsertId($sequencia);
        $this->DB()->commit();
        return $id;
    } else {
        return false;
    }
   }
}