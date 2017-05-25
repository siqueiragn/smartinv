<?php

define('VERSAO', '1.0');

class ViewUpdater
{

    private $local = array();
    private $remoto = array();

    public function __construct()
    {
        $this->requires();
        $VERSAO = VERSAO;
        if (isset($_POST['enviar'])) {
            $this->lerVariaveis();
            $RESULTADO = $this->gerar();
        } else {
            $this->local['bd'] = $this->remoto['bd'] = DB_NAME;
            $this->local['server'] = DB_SERVER;
            $this->remoto['server'] = '';
            $this->local['usuario'] = $this->remoto['usuario'] = DB_USER;
            $this->local['senha'] = $this->remoto['senha'] = DB_PASSWORD;
            $RESULTADO = '';
        }
        $LOCAL = $this->local;
        $REMOTO = $this->remoto;
        include __DIR__ . '/extras/viewUpdater/form.html';
    }

    private function lerVariaveis()
    {
        $this->local['bd'] = filter_input(INPUT_POST, 'bdLocal', FILTER_SANITIZE_STRING);
        $this->local['usuario'] = filter_input(INPUT_POST, 'usuarioLocal', FILTER_SANITIZE_STRING);
        $this->local['senha'] = filter_input(INPUT_POST, 'senhaLocal', FILTER_SANITIZE_STRING);
        $this->local['server'] = filter_input(INPUT_POST, 'serverLocal', FILTER_SANITIZE_STRING);
        $this->remoto['bd'] = filter_input(INPUT_POST, 'bdRemoto', FILTER_SANITIZE_STRING);
        $this->remoto['usuario'] = filter_input(INPUT_POST, 'usuarioRemoto', FILTER_SANITIZE_STRING);
        $this->remoto['senha'] = filter_input(INPUT_POST, 'senhaRemoto', FILTER_SANITIZE_STRING);
        $this->remoto['server'] = filter_input(INPUT_POST, 'serverRemoto', FILTER_SANITIZE_STRING);
        DebugUtil::show($this);
    }

    private function gerar()
    {
        ob_start();
        echo 'Selecionando views' . PHP_EOL;
        $views = $this->selecionaViews();
        echo 'Instalando no servidor ' . PHP_EOL;
        $this->atualizaViews($views);
        $retorno = ob_get_contents();
        ob_end_clean();
        return $retorno;
    }

    private function selecionaViews()
    {
        $views = array();
        $modelo = new ModeloBD($this->local['bd'], $this->local['server']);

        $sql = "SELECT  n.nspname AS schemaname,
        c.relname AS viewname, 
        pg_catalog.obj_description(c.oid, 'pg_class') AS comments,
        CASE c.relkind
            WHEN 'v'
            THEN pg_catalog.pg_get_viewdef(c.oid, true)
            ELSE null
            END AS definition
        FROM pg_catalog.pg_class c
            LEFT JOIN pg_catalog.pg_namespace n ON (n.oid = c.relnamespace)
           
            LEFT JOIN pg_catalog.pg_stat_all_tables s ON (c.oid = s.relid)
        WHERE c.relkind  = 'v' AND nspname NOT IN ('pg_catalog', 'information_schema') ";

        foreach ($modelo->query($sql) as $result) {
            $views[$result['schemaname'] . '.' . $result['viewname']] = array('CREATE OR REPLACE VIEW ' . $result['schemaname'] . '.' . $result['viewname'] . ' AS ' . $result['definition'] . ';',
                'COMMENT ON VIEW ' . $result['schemaname'] . '.' . $result['viewname'] . " IS '" . $result['comments'] . "'");
        }
        return $views;
    }

    private function exibeViews()
    {
        
    }

    private function atualizaViews($viewsSelecionadas)
    {
        $modeloRemoto = new ModeloBD($this->remoto['bd'], $this->remoto['server'], $this->remoto['usuario'], $this->remoto['senha']);
        foreach ($viewsSelecionadas as $v => $sql) {
            echo 'Criando a view ' . $v . PHP_EOL . PHP_EOL;
            $modeloRemoto->query($sql[0]);
            $modeloRemoto->query($sql[1]);
        }
    }

    private function requires()
    {
        require_once __DIR__ . '/geradorCrud/ModeloBD.class.php';
    }

}
