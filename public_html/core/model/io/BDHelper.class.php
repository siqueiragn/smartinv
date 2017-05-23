<?php

/**
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0.0
 */
class BDHelper
{

    /**
     *
     * @var PDO 
     */
    protected $database;
    private $debug;
    private $lastQuery = '';
    private $inTrasaction = false;

    public function __construct($dbName, $databaseType, $dbServer, $user, $password)
    {
        $this->debug = false;
        $str = $databaseType . ':host=' . $dbServer . ';dbname=' . $dbName;
        $this->database = new PDO($str, $user, $password);
    }

    public function debugOn($status = true)
    {
        $this->debug = $status;
        
        if ($this->debug) {
            $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
    }

    public function begin()
    {
        $this->inTrasaction = true;
        return $this->database->beginTransaction();
    }

    public function rollback()
    {
        $this->inTrasaction = false;
        return $this->database->rollBack();
    }

    public function commit()
    {
        $this->inTrasaction = false;
        return $this->database->commit();
    }
    
    public function inTransaction(){
        return $this->inTrasaction;
    }
    
    
    public function saveFile($table, $colunm, $file, $extras = array()){
        
    }
    
    public function readFile($table, $colunm, $file, $extras = array()){
        
    }

    public function queryAsArray($sql)
    {
        $return = array();
        $data = array();

        foreach ($this->database->query($sql) as $return) {
            array_push($data, $return);
        }

        return $data;
    }

    /**
     * 
     * @param type $sql
     * @return PDOStatement
     * @throws SQLException
     */
    public function query($sql)
    {
        $this->lastQuery = $sql;
        if ($this->debug) {
            DebugUtil::show($sql);
        }
        try {
            return $this->database->query($sql);
        } catch (PDOException $exception) {
            throw new SQLException($exception, $sql);
        }
    }

    /**
     * 
     * @param type $table
     * @param type $fields
     * @param misc $condition Se String aplica a condição caso, for um array usa Prepared
     * @param type $order
     * @param type $limit
     * @return SQLPointer
     */
    public function queryTable($table, $fields = '*', $condition = null, $order = null, $limit = null)
    {
        $sql = 'SELECT ' . $fields . ' FROM ' . $table;
    
        if (isset($condition) && $condition) {
            if(is_array($condition)){
                //ver de montar o prepared
            }
            $sql .= ' WHERE ' . $condition;
        }

        if (isset($order)) {
            $sql .= ' ORDER BY ' . $order;
        }

        if (isset($limit)) {
            $sql .= ' LIMIT ' . $limit;
        }
        return $this->query($sql);
    }

    /**
     * Método que realiza um insert no banco de dados.
     * 
     * @param String $table
     * @param misc $data
     * @return boolean
     */
    public function insert($table, $data)
    {
        $sql = 'INSERT INTO ' . $table . ' ';

        //Verifica se é array para percorrer com foreach
        if (is_array($data)) {
            $sql .= '(';
            $values = '';
            //Acrescenta o nome dos campos
            foreach ($data as $name => $value) {
                $sql .= $name . ',';
                $values .= '?,';
            }

            //Retira a última vírgula, para não ser necessário fazer um contador
            $sql = trim($sql, ',');
            $placeHolders = implode(',', array_fill(0, count($data), '?'));
            $sql .= ') ';
            $sql .= 'VALUES (' . $placeHolders . ')';

            return $this->execute($sql, $data);
        } else {
            $sql .= $data;
        }

        return $this->exec($sql);
    }

    public function update($table, $data, $condition)
    {
        $sql = 'UPDATE ' . $table . ' SET ';
        $isArray = false;
        //Verifica se é objeto ou array para percorrer com foreach
        if (is_array($data)) {
            //Percorre os campos e os valores
            foreach ($data as $name => $value) {
                if (is_object($value)) {
                    unset($data[$name]);
                    $valor = $value->codigoInsercao();
                } else {
                    $valor = '?';
                }
                $sql .= $name . '= ' . $valor . ' ,';
            }

            //Retira a vírgula excedente
            $sql = trim($sql, ",");
            $isArray = true;
        } else {
            $sql .= $data;
        }

        if (isset($condition)) {
            $sql .= ' WHERE ' . $condition;
        }
        if ($isArray) {
            return $this->execute($sql, $data);
        }
        $this->lastQuery = $sql;
        return $this->exec($sql);
    }

    public function delete($table, $condition)
    {
        if (is_array($condition)) {
            
        } else {
            $sql = 'DELETE FROM ' . $table . ' WHERE ' . $condition;
        }
        return $this->exec($sql);
    }

    /**
     * 
     * @param String $sql
     * @param Array $data
     * @return bool <b>TRUE</b> no caso de sucesso ou <b>FALSE</b> caso ocora alguma falha.
     * @throws SQLException
     */
    private function execute($sql, $data)
    {
        try {
            if ($this->debug) {
                DebugUtil::show($sql);
                DebugUtil::show($data);;
            }
            $stmt = $this->database->prepare($sql);
            $this->lastQuery = $sql;
            return $stmt->execute(array_values($data));
        } catch (PDOException $exception) {
            throw new SQLException($exception, $sql, array_values($data));
        }
    }

    private function exec($sql)
    {
        try {
            if ($this->debug) {
                DebugUtil::show($sql);
            }
            return $this->database->exec($sql);
        } catch (PDOException $exception) {
            throw new SQLException($exception, $sql);
        }
    }
    
    /**
     * 
     * @param String $name sequence_name ou tabela
     * @return type
     */
    public function lastInsertId($name){
        return $this->database->lastInsertId($name);
    }

    public function __destruct()
    {
        if($this->inTrasaction){            
            $this->commit();//FIXME ver se não é melhor lançar uma exceção
        }
        $this->database = null;
    }

}
