<?php

define('VERSAO', '1.0 02/11/2015');
require_once __DIR__ . '/base/Gerador.class.php';

/**
 * Classe responsável por gerar classes.
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0.0
 */
class GeradorDeCrud extends Gerador
{

    private $dicionario = array();
    private $ignores = array();

    public function __construct()
    {
        parent::__construct();
        $this->requires();
        $this->trataForm();
    }

    private function trataForm()
    {
        $VERSAO = VERSAO;
        if (isset($_POST['enviar'])) {
            $RESULTADO = $this->gerar();
            $nomeDao = filter_input(INPUT_POST, 'nomeDao', FILTER_SANITIZE_STRING);
            $campos = filter_input(INPUT_POST, 'campos', FILTER_SANITIZE_STRING);
        } else {
            $RESULTADO = $nomeDao = $campos = '';
        }
        $CONF = $this->conf;
        $SCRIPT = $this->getScripts();

        include __DIR__ . '/geradorCrud/view/form.phtml';
    }

    private function getScripts()
    {
        return file_get_contents(__DIR__ . '/geradorCrud/interface.js');
    }

    public function preparaPastaClasses()
    {
        echo '-- Criando diretórios';
        system('rm -rf /tmp/classes');
        mkdir('/tmp/classes', 0777);
        mkdir('/tmp/classes/control', 0777);
        mkdir('/tmp/classes/model', 0777);
        mkdir('/tmp/classes/model/DTO', 0777);
        mkdir('/tmp/classes/view', 0777);
        mkdir('/tmp/classes/view/templates', 0777);
        mkdir('/tmp/classes/view/templates/forms', 0777);
        mkdir('/tmp/classes/model/DAO', 0777);
        if ($this->conf->isAdmin()) {
            mkdir('/tmp/classes/control/admin', 0777);
        }
    }

    public function requires()
    {
        parent::requires();
        require_once __DIR__ . '/geradorCrud/CampoGerador.class.php';
        require_once __DIR__ . '/geradorCrud/TabelaGerador.class.php';
        require_once __DIR__ . '/geradorCrud/ArquivoGerador.class.php';
        require_once __DIR__ . '/geradorCrud/ModeloGerador.class.php';
        require_once __DIR__ . '/geradorCrud/ControleGerador.class.php';
        require_once __DIR__ . '/geradorCrud/DataTransferGerador.class.php';
        require_once __DIR__ . '/geradorCrud/ColunaGerador.class.php';
        require_once __DIR__ . '/geradorCrud/TemplateGerador.class.php';
        require_once __DIR__ . '/geradorCrud/TituloTabelaGerador.class.php';
        require_once __DIR__ . '/geradorCrud/ModeloBD.class.php';
    }

    private function gerarApenasDataAccess($nomeDao, $campos)
    {
        echo '<pre>';
        $dao = $this->geraDataTransfer($nomeDao, $campos);
        echo htmlspecialchars($dao);
    }

    private function gerar()
    {
        ob_start();
        $this->setarConfiguracoes($_POST);
        $this->executaGerador();

        $retorno = ob_get_contents();
        ob_end_clean();
        return $retorno;
    }

    private function executaGerador()
    {
        extract($_POST);
        $nomeDao = filter_input(INPUT_POST, 'nomeDao', FILTER_SANITIZE_STRING);
        $campos = filter_input(INPUT_POST, 'campos', FILTER_SANITIZE_STRING);

        if (isset($gerarBanco)) {
            $dtos = empty($nomeDao) ? false : $nomeDao;
            $this->preparaPastaClasses();
            $this->gerarBanco($nomeBanco, $dtos);
        } else {
            $this->gerarApenasDataAccess($nomeDao, $campos);
        }
    }

    private function setarConfiguracoes($conf)
    {

        $this->conf->setAutor($conf['autor'])
                ->setEmailAutor($conf['emailAutor'])
                ->setBanco($conf['nomeBanco']);

        $this->conf->setGerarBanco(isset($conf['gerarBanco']) ? $conf['gerarBanco'] : false);
        $this->conf->setDeletar(isset($conf['deletar']) ? $conf['deletar'] : false);
        $this->conf->setRewrite(@$_POST['rewrite']);
        $this->conf->setUrlAdicional(@$_POST['urlAdicional']);
        $this->conf->setAdmin(isset($conf['modoAdmin']) ? $conf['modoAdmin'] : false);

        //Em standby a partir da versão 1 do enyalius
        $int = isset($conf['internacionalizacao']) ? $conf['internacionalizacao'] : false;
        $this->conf->setInternacionalizacao($int);

        $esquemasGlobais = array(
            'public' => '',
            'system' => 'admin'
        );

        $GLOBALS['bancoPadrao'] = true;
        $GLOBALS['urlAdicional'] = $conf['urlAdicional'];

        $this->conf->setEsquemas($esquemasGlobais);
    }

    function geraControlador(\TabelaGerador $tabela = null)
    {
        $controlador = new ControleGerador();

        $controlador->setTabela($tabela);
        $controlador->setNome(ucfirst($tabela->getNomeTabela()));
        $controlador->setSchema($tabela->getSchema());
        $controlador->setConfig($this->conf);

        return $controlador->gerar();
    }

    private function geraDataTransfer($nomeDTO, $campos, \TabelaGerador $tabelaObj = null)
    {
        $dataTransfer = new DataTransferGerador();
        $dataTransfer->setConfig($this->conf);
        if ($tabelaObj == null) {
            $tabelaObj = new TabelaGerador($nomeDTO);
            $tabelaObj->setColunas(explode(',', $campos));
        }
        $dataTransfer->setTabela($tabelaObj);
        return $dataTransfer->gerar();
    }

    private function geraDAO(\TabelaGerador $tabela = null)
    {
        $modelo = new ModeloGerador();
        $modelo->setTabela($tabela);
        $modelo->setConfig($this->conf);
        return $modelo->gerar();
    }

    function geraTpl(\TabelaGerador $tabela = null)
    {
        $tpl = new TemplateGerador();
        $tpl->setTabela($tabela);
        $tpl->setConfig($this->conf);
        return $tpl->gerar();
    }

    private function montaQueryTabelas($dtos)
    {
        $query = "SELECT   schemaname AS esquema,
                        tablename AS tabela
               FROM pg_catalog.pg_tables
                                                WHERE schemaname NOT IN
                                                ('pg_catalog',
                                                'information_schema',
                                                'pg_toast')";
        if ($dtos) {
            list($tabelas, $schemas, $tabelaEspecificas) = $this->trataTabelas($dtos);
            $query .= ' AND ';
            if (sizeof($tabelas) > 0) {
                $query .= " tablename IN ('" . $tabelas . "') OR";
                echo '* Tabelas Selecionadas =>' . $tabelas . PHP_EOL;
            }
            if (sizeof($schemas) > 0) {
                $query .= " schemaname IN ('" . $schemas . "') OR";
                echo '* Schemas completos selecionadas =>' . $schemas . PHP_EOL;
            }
            $query = rtrim($query, ' OR');
        }
        $query .= "                               ORDER BY schemaname, tablename";
        return $query;
    }

    public function gerarBanco($nomeBanco, $dtos = false)
    {
        echo '<h1>Gerando arquivos do banco ' . $nomeBanco . '</h1>' . PHP_EOL;
        $modelo = new ModeloBD($nomeBanco);
        $consulta = $modelo->query($this->montaQueryTabelas($dtos));

        $esquemaAtual = '';
        while ($linha = $modelo->resultadoAssoc($consulta)) {
            if ($linha['tabela'] == 'custom_fields_lists') {
                continue;
            }
            $esquema = $linha['esquema'];
            $dir = '/tmp/classes/';
            $admin = $this->conf->isAdmin() ? 'admin/' : '';

            if ($esquema != $esquemaAtual) {
                $esquemaAtual = $esquema;
                $dirModulo = isset($this->conf->getEsquemas()[$esquema]) ? ($this->conf->getEsquemas()[$esquema]) : $esquema;
                $dirModulo = $dirModulo == 'public' ? '' : $dirModulo;
                if (!is_dir('/tmp/classes/' . $dirModulo)) {
                    echo 'Criando diretório ' . $dirModulo . PHP_EOL;
                    mkdir('/tmp/classes/control/' . $admin . $dirModulo, 0777);
                    mkdir('/tmp/classes/model/DAO/' . $dirModulo, 0777);
                    mkdir('/tmp/classes/model/DTO/' . $dirModulo, 0777);
                    mkdir('/tmp/classes/view/templates/' . $dirModulo, 0777);
                    mkdir('/tmp/classes/view/templates/' . $dirModulo . '/forms', 0777);
                }
            }
            $tabela = new TabelaGerador($esquema . '.' . $linha['tabela']);
            $tabela->carrega($modelo);

            echo '<h3>' . $tabela->getLabel() . '</h3>';
            echo 'Gerando Classe ' . $tabela->getNomeCamelCase();

            $fp = fopen($dir . 'model/DTO/' . $dirModulo . '/' . $tabela->getNomeCamelCase() . '.class.php', 'wb');

            $texto = $this->geraDataTransfer($tabela->getLabel(), false, $tabela);
            fwrite($fp, $texto);
            fclose($fp);
            print("<br><hr><br>");
            echo 'Gerando Classe Controlador' . $tabela->getLabel() . PHP_EOL;
            $fileControlador = fopen($dir . 'control/' . $admin . $dirModulo . '/' . 'Controlador' . $tabela->getNomeCamelCase() . '.class.php', 'wb');
            $codigoControlador = $this->geraControlador($tabela);
            fwrite($fileControlador, $codigoControlador);
            fclose($fileControlador);
            echo "<br><hr><br>";
            echo 'Gerando Classe ' . $tabela->getLabel() . 'DAO.class.php' . PHP_EOL;
            $fp = fopen($dir . '/model/DAO/' . $dirModulo . '/' . $tabela->getNomeCamelCase() . 'DAO.class.php', 'wb');
            $texto = $this->geraDAO($tabela);
            fwrite($fp, $texto);
            fclose($fp);
            echo "<br><hr><br>";
            echo 'Gerando Template ' . $tabela->getLabel() . PHP_EOL;
            $fp = fopen($dir . 'view/templates/' . $dirModulo . '/forms/' . $tabela->getNomeTabela() . '.tpl', 'wb');
            $texto = $this->geraTpl($tabela, $tabela);
            fwrite($fp, $texto);
            fclose($fp);
            print("<br><hr><br>");
        }
    }

    private function trataTabelas($string)
    {
        $string = str_replace("\n", '', $string);
        $tabelas = explode(',', $string);
        $listaTabelas = $listaSchemas = $tabelasComEsquema = array();
        if (count($tabelas) > 1) {
            foreach ($tabelas as $tabela) {
                $result = $this->extractSchema($tabela);
                if(is_array($result) && sizeof($result) > 1) {
                    $tabelasComEsquema[] = $result[0];
                }else if(is_array($result)) {
                    $listaSchemas = $result[0];
                }else {
                    $listaTabelas[] = $result;
                }
            }
            $tabelas = implode("', '", $listaTabelas);
            $tabelas = rtrim($tabelas, ", '");
        } else {
            $tabelas = $string;
        }
        return array($tabelas, $listaSchemas, $tabelasComEsquema);
    }

    private function extractSchema($tabela)
    {
        $tabela = trim($tabela);
        $pieces = explode('.', $tabela);
        if (count($pieces) > 1) {
            if ($pieces[1] == '*') {
                return array($pieces[0]);
            } else {
                return $pieces;
            }
            
        } else {
            return $tabela;
        }
    }

}
