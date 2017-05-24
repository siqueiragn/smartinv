<?php

/**
 * Description of AbstractModel
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package core.model
 */
abstract class AbstractModel
{

    /**
     *
     * @var BDHelper
     */
    protected $db;
    protected $erro = 'Erro não identificado';

    /**
     * 
     * @param String $dbName nome do banco de dados
     * @param type $helper
     * @param type $server
     * @param type $user
     * @param type $pass
     */
    public function __construct(    $dbName = DB_NAME,
                                    $server = DB_SERVER, 
                                    $user = DB_USER, 
                                    $pass = DB_PASSWORD)
    {
        $this->registerRequires();
        if (DB_TYPE == 'pgsql') {
            $this->db = new PGHelper($dbName, $server, $user, $pass);
        } else {
            $this->db = new BDHelper($dbName, DB_TYPE, $server, $user, $pass);
        }
    }
    
    public function  getErro(){
        return $this->erro;
    }

    /**
     * 
     * @param type $sql
     * @return PDOStatement
     */
    public function query($sql)
    {
        return $this->db->query($sql);
    }
    
    /**
     * 
     * @return BDHelper
     */
    public function DB(){
        return $this->db;
    }

    /**
     * 
     * @param type $table
     * @param type $fields
     * @param type $condition
     * @param type $order
     * @param type $limit
     * @return PDOStatement
     */
    public function queryTable($table, $fields = '*', $condition = null, $order = null, $limit = null)
    {
        return $this->db->queryTable($table, $fields, $condition, $order, $limit);
    }

    /**
     * Método retrocompativel com resultadoAssoc depreciado usar
     * 
     * foreach($consulta as $linha)
     * 
     * @deprecated since version 1.0
     * @param type $result
     * @return type
     */
    public function resultAssoc(PDOStatement $result)
    {
        return $result->fetch();
    }
    
    
    public function rowCount(PDOStatement $consulta){
        return count($consulta->fetchAll());
    }
     
    /**
     * Método que cria um mapa de dados simples para se utilizar em campos de
     * seleção e etc. O modelo do mapa é $mapa['INDICE_DO_DADO'] = 'VALOR_DO_DADO'
     *
     * @param Resource $consulta
     * @param string $indice
     * @param String $valor
     * @return array Mapa com os dados
     */
    public function getMapaSimplesDados($consulta, $indice, $valor) {
        $array = array();
        if($consulta){
            foreach ($consulta as $linha) {
                $array[$linha[$indice]] = $linha[$valor];
            }
        }
        return $array;
    }


    private function registerRequires()
    {
        /**
         * @var AutoLoader
         */
        $loader = $GLOBALS['loader'];
        $loader->addClass('PGHelper', CORE . 'model/io/PGHelper');
        $loader->addClass('BDHelper', CORE . 'model/io/BDHelper');
    }

}
