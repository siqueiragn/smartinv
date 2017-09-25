<?php

/**
 * Classe com as expecificações do PostgreSQL para o PDO.
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package core.model.io
 */
class PGHelper extends BDHelper
{
    public function __construct($dbName, $server, $user, $pass)
    {
        parent::__construct($dbName, 'pgsql', $server, $user, $pass);
    }
    
    /**
     * Método que retorna o próximo valor da tabela e registra esse numero para 
     * a operação garantindo a consistência dos dados e a normalização dos mesmos.
     *
     * @param String  $tabela = Nome da tabela que fornecerá o próximo valor
     * @return Integer $proximoValor = Valor do próximo valor auto-incrementável.
     */
    public function nextValue($tabela) {
        $tabelaComSchema = explode('.', $tabela);
        if (sizeof($tabelaComSchema) == 2) {
            $query = "SELECT nextval('" . $tabela . '_id_' . $tabelaComSchema[1] . "_seq'::regclass)";
        } else {
            $query = "SELECT nextval('" . $tabela . '_id_' . $tabela . "_seq'::regclass)";
        }
        $result = $this->query($query);
        if ($result) {
            $array = $this->resultadoAssoc($result);
            return $array['nextval'];
        }
        return false;
    }
    
    public function saveFile($table, $colunm, $file, $extras = array())
    {
        if(isset($extras['type']) &&  $extras['type'] == 'bytea'){
            //FIXME gerar código para  inserir como bytea
        }else{//oid
                       
        }
    }
    
    public function geraOid($file){
        if (!$this->inTransaction()) {
            throw new SQLException("Voce deve estar em uma transação");
        }
        DebugUtil::show($file);
        $oid = $this->database->pgsqlLOBCreate();
        $stream = $this->database->pgsqlLOBOpen($oid, 'w');
        $local = fopen($file, 'rb');
        DebugUtil::show($oid);
        stream_copy_to_stream($local, $stream);
        $local = null;
        $stream = null;
        return $oid;
    }

}
