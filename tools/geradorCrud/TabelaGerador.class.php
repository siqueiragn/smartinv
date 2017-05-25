<?php

/**
 * Classe responsável por ler os metadados de Tabela
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0.0 2015-12-12
 */
class TabelaGerador
{

    private $nomeCompleto;
    private $nomeTabela;
    private $tituloTabela;
    private $schema;
    private $colunas = array();
    private $chavePrimaria = array();
    private $camposGeograficos = array();
    private $camposArquivos = array();
    private $camposImagens = array();

    public function __construct($nomeCompleto)
    {
        if (strpos($nomeCompleto, '.') !== false) {
            list($this->schema, $this->nomeTabela) = explode('.', $nomeCompleto);
            $this->nomeCompleto = $nomeCompleto;
        } else {
            $this->schema = 'public';
            $this->nomeTabela = $nomeCompleto;
            $this->nomeCompleto = $this->schema . $this->nomeTabela;
        }
        $this->tituloTabela = new TituloTabelaGerador($this->nomeTabela);
    }

    /**
     * Método que retorna a quantidade de campos arquivos que o
     * @return int
     */
    public function possuiArquivo()
    {
        return count($this->camposArquivos);
    }

    public function possuiCamposGeograficos()
    {
        return count($this->camposGeograficos);
    }

    /**
     * Método que retorna a quantidade de campos arquivos que o
     * @return int
     */
    public function possuiImagens()
    {
        return count($this->camposImagens);
    }

    public function getCamposArquivos()
    {
        return $this->camposArquivos;
    }

    public function getCamposImagens()
    {
        return $this->camposImagens;
    }

    public function setColunas($colunas)
    {
        foreach ($colunas as $coluna) {
            $this->colunas[] = new ColunaGerador($coluna);
        }
    }

    /**
     *
     * @return String Nome da tabela completo com Schema e nome da tabela
     */
    public function getNomeCompleto()
    {
        return $this->nomeCompleto;
    }

    public function getSchema()
    {
        return $this->schema;
    }

    /**
     *
     * @return String Nome da tabela sem schema
     */
    public function getNomeTabela()
    {
        return $this->nomeTabela;
    }

    /**
     *
     * @return String
     */
    public function getLabel()
    {
        return $this->tituloTabela->getLabel();
    }

    /**
     *
     * @return Array<ColunaGerador> - Lista de objetos do tipo
     */
    public function getColunas()
    {
        return $this->colunas;
    }

    public function getChavePrimaria()
    {
        return $this->chavePrimaria;
    }

    public function getNomeCamelCase()
    {
        return ucfirst($this->tituloTabela->getVariavel());
    }
    
    /**
     * Método que verifica se a tabela possui chave composta 
     * 
     * @return boolean
     */
    public function isChaveComposta(){
        if(sizeof($this->chavePrimaria)>1){
            return true;
        }else{
            return false;
        }
    }

    public function carrega(ModeloBD $modelo)
    {
        $consulta = $modelo->query("SELECT
    f.attnum AS number,
    f.attname AS name,
    f.attnum,
    f.attnotnull AS notnull,
    pg_catalog.format_type(f.atttypid,f.atttypmod) AS type,
    CASE
        WHEN p.contype = 'p' THEN 't'
        ELSE 'f'
    END AS primarykey,
    CASE
        WHEN p.contype = 'u' THEN 't'
        ELSE 'f'
    END AS uniquekey,
    CASE
        WHEN p.contype = 'f' THEN p.confkey
    END AS foreignkey_fieldnum,
    CASE
        WHEN p.contype = 'f' THEN g.relname
    END AS foreignkey,
    CASE
        WHEN p.contype = 'f' THEN p.conkey
    END AS foreignkey_connnum,
    CASE
        WHEN f.atthasdef = 't' THEN d.adsrc
    END AS default
FROM pg_attribute f
    JOIN pg_class c ON c.oid = f.attrelid
    JOIN pg_type t ON t.oid = f.atttypid
    LEFT JOIN pg_attrdef d ON d.adrelid = c.oid AND d.adnum = f.attnum
    LEFT JOIN pg_namespace n ON n.oid = c.relnamespace
    LEFT JOIN pg_constraint p ON p.conrelid = c.oid AND f.attnum = ANY (p.conkey)
    LEFT JOIN pg_class AS g ON p.confrelid = g.oid

WHERE c.relkind = 'r'::char
    AND n.nspname = '" . $this->schema . "'
    AND c.relname = '" . $this->nomeTabela . "'
    AND f.attnum > 0 ORDER BY number");

        $colunas = array();
        $i = 0;
        foreach ($consulta as $linha) {
            $colunas[$linha['name']] = array(
                'col_name' => $linha['name'],
                'is_null' => $linha['notnull'],
                'data_type' => $linha['type']);


            $coluna = new ColunaGerador($linha['name']);
            $coluna->setTipo($linha['type']);

            $coluna->setNotNull($linha['notnull']);
            $coluna->setChavePrimaria($linha['primarykey']);
            $coluna->setChaveEstrangeira($linha['foreignkey']);
            if (isset($this->colunas[$linha['number']])) {
                $this->colunas[$linha['number']] = $this->merge($coluna, $this->colunas[$linha['number']]);
            } else {
                $this->colunas[$linha['number']] = $coluna;
            }

            if ($coluna->isChavePrimaria()) {
                $this->addChavePrimaria($coluna);
            }
            $coluna->verificaObjeto();

            if ($coluna->isGeo()) {
                $this->camposGeograficos[] = $coluna;
            }

            if ($coluna->isArquivo()) {
                $this->camposArquivos[] = $coluna;
            }

            if ($coluna->isImagem()) {
                $this->camposImagens[] = $coluna;
            }
        }
    }

    private function merge(ColunaGerador $x, ColunaGerador $y)
    {
        if ($x->isNotNull() || $y->isNotNull()) {
            $x->setNotNull(true);
        }
        if ($x->isChaveEstrangeira() || $y->isChaveEstrangeira()) {
            if (!empty($x->getChaveEstrangeiraRelacao())) {
                $chave = $x->getChaveEstrangeiraRelacao();
            } else {
                $chave = $y->getChaveEstrangeiraRelacao();
            }
            $x->setChaveEstrangeira($chave);
        }
        if ($x->isChavePrimaria() || $y->isChavePrimaria()) {
            $x->setChavePrimaria(true);
        }
        return $x;
    }

    /**
     * Método que adicionas as colunas que são chave primária.
     * 
     * @param ColunaGerador $chave
     */
    private function addChavePrimaria(ColunaGerador $chave)
    {
        $this->chavePrimaria[$chave->getNome()] = $chave;
    }
    
    

}
