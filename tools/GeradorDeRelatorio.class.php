<?php

define('VERSAO', '1.0');

/**
 * Description of GeradorDeRelatorio
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @package tools
 * @version 1.0 2016-01-04
 */
class GeradorDeRelatorio
{

    private $bd;
    private $dirPadrao = '/tmp/classes';
    private $conf;
    private $iniFile = array();

    public function __construct()
    {
        $this->bd = DB_NAME;
        $this->requires();
        $this->iniFile();
        $this->conf = new ConfiguracaoGerador();
        $this->trataForm();
    }

    private function trataForm()
    {
        $VERSAO = VERSAO;
        if (isset($_POST['enviar'])) {

            $this->bd = filter_input(INPUT_POST, 'bd', FILTER_SANITIZE_STRING);
            $RESULTADO = $this->gerar();
        } else {
            $RESULTADO = '';
        }
        $BD = $this->bd;
        $CONF = $this->conf;
        include __DIR__ . '/geradorRelatorio/forms/form.html';
    }

    private function gerar()
    {
        ob_start();
        $this->criarDiretorios();
        $this->consultaViews();
        $retorno = ob_get_contents();
        ob_end_clean();
        return $retorno;
    }

    private function geraControlador(View $v)
    {
        $controle = new ControleRelatorio($v, $this->conf);
        $texto = $controle->gerar();
        $fp = fopen($this->dirPadrao . '/control/relatorios/' . $v->getModulo() . '/Controlador' . $v->getNomeCamelCase() . '.class.php', 'wb');

        fwrite($fp, $texto);
        fclose($fp);
    }

    private function geraModelo(View $v)
    {
        $modelo = new ModeloRelatorio($v, $this->conf);
        $texto = $modelo->gerar();
        $fp = fopen($this->dirPadrao . '/model/relatorios/' . $v->getModulo() . '/' . $v->getNomeCamelCase() . 'Model.class.php', 'wb');

        fwrite($fp, $texto);
        fclose($fp);
    }

    private function consultaViews()
    {
        echo 'Processo iniciado!' . PHP_EOL;
        $views = filter_input(INPUT_POST, 'views', FILTER_SANITIZE_STRING);
        if (empty($views)) {
            echo 'Gerando todas as views...' . PHP_EOL;
            // select schemaname, viewname from pg_catalog.pg_views where schemaname NOT IN ('pg_catalog', 'information_schema') order by schemaname, viewname;
        } else {
            echo 'Gerando views informadas... ' . $views . PHP_EOL;
            $listaViews = explode(',', $views);
            foreach ($listaViews as $view) {
                echo PHP_EOL . PHP_EOL . '<b>[Nova view]</b> ' . $view . PHP_EOL;
                $this->geraView($view);
            }
        }
    }

    private function geraView($nome)
    {
        $modelo = new ModeloBD($this->bd);
        $view = new View($nome);
        $view->setDicionario($this->iniFile['dicionario']);
        $view->carrega($modelo);
        $this->geraModelo($view);
        $this->geraControlador($view);
    }

    private function requires()
    {
        require_once __DIR__ . '/geradorCrud/ModeloBD.class.php';
        require_once __DIR__ . '/base/ConfiguracaoGerador.class.php';
        require_once __DIR__ . '/geradorRelatorio/View.class.php';
        require_once __DIR__ . '/geradorRelatorio/Coluna.class.php';
        require_once __DIR__ . '/geradorRelatorio/ModeloRelatorio.class.php';
        require_once __DIR__ . '/geradorRelatorio/ControleRelatorio.class.php';
    }

    private function criarDiretorios()
    {
        echo 'Criando diretórios em ' . $this->dirPadrao . PHP_EOL;
        system('rm -rf ' . $this->dirPadrao);
        mkdir($this->dirPadrao, 0777);
        mkdir($this->dirPadrao . '/control', 0777);
        mkdir($this->dirPadrao . '/control/relatorios', 0777);
        mkdir($this->dirPadrao . '/model', 0777);
        mkdir($this->dirPadrao . '/model/relatorios', 0777);
    }

    private function iniFile()
    {
        $this->iniFile = parse_ini_file(__DIR__ . '/extras/dados.ini', true);
    }

}
