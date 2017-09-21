<?php

/**
 * Classe que representa uma View de banco de dados.
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
class View
{

    private $nome;
    private $schema;
    private $dono;
    private $comentario;
    private $colunas = array();
    private $query;
    private $dicionario = array();

    public function __construct($nome, $schema = 'public')
    {
        $this->nome = $nome;
        $this->schema = $schema;
    }

    public function addColunm(Coluna $c)
    {
        $this->colunas[] = $c;
    }

    public function carrega(AbstractModel $m)
    {
        $sql = "SELECT  n.nspname AS table_schema,
        pg_catalog.pg_get_userbyid(c.relowner) AS dono,
        c.relname AS table_name, a.attname AS nome_coluna,
        pg_catalog.obj_description(c.oid, 'pg_class') AS comments,
        pg_catalog.format_type(a.atttypid,a.atttypmod) AS tipo, 
        CASE c.relkind
            WHEN 'v'
            THEN pg_catalog.pg_get_viewdef(c.oid, true)
            ELSE null
            END AS query
        FROM pg_catalog.pg_class c
            LEFT JOIN pg_catalog.pg_namespace n ON (n.oid = c.relnamespace)
            LEFT JOIN pg_catalog.pg_attribute a ON (c.oid = a.attrelid AND a.attnum > 0 AND NOT a.attisdropped)
            LEFT JOIN pg_catalog.pg_stat_all_tables s ON (c.oid = s.relid)
        WHERE c.relkind  = 'v' AND nspname NOT IN ('pg_catalog', 'information_schema') 
            AND n.nspname = '" . $this->schema . "'  
            AND c.relname = '" . $this->nome . "'  

        ORDER BY c.relname ASC,
                 a.attnum ;";
        $result = $m->query($sql);
        if ($result->rowCount()) {
            foreach ($result as $linha) {
                $coluna = new Coluna($linha['nome_coluna']);
                $coluna->setTipo($linha['tipo']);
                $coluna->setDicionario($this->dicionario);
                $this->addColunm($coluna);
            }
            $this->setDono($linha['dono'])
                    ->setQuery($linha['query'])
                    ->setComentario($linha['comments']);
        } else {
            echo 'View ' . $this->schema . '.' . $this->nome . ' não existe!';
        }
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getSchema()
    {
        return $this->schema;
    }

    public function getDono()
    {
        return $this->dono;
    }

    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Método que retorna todas as colunas da view.
     * 
     * @return Coluna[]
     */
    public function getColunas()
    {
        return $this->colunas;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function setSchema($schema)
    {
        $this->schema = $schema;
        return $this;
    }

    public function setDono($dono)
    {
        $this->dono = $dono;
        return $this;
    }

    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
        return $this;
    }

    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    public function setDicionario($dicionario)
    {
        $this->dicionario = $dicionario;
        return $this;
    }

    public function getNomeCamelCase()
    {
        return StringUtil::toCamelCase($this->nome, true);
    }

    public function getModulo()
    {
        if (!$this->schema == 'public') {
            return StringUtil::toCamelCase($this->schema);
        }
    }

    /**
     * Retorna o nome da view em formato de label formatado e acentuado conforme o dicionario.
     * 
     * @return String Nome Formatado.
     */
    public function getLabel()
    {
        return StringUtil::replaceByDictionary($this->nome, $this->dicionario);
    }
    
    public function getNomeCompleto(){
        return $this->schema . '.' .$this->getNome();
    }

}
