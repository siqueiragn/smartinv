<?php

/**
 * Description of AbstractView
 *
 * Changelog
 * 1.0.0 - Features fundamentais
 * 2.0.0 - 
 *   -Movimentação do core client para o servidor enviando apenas os arquivos compactados para a pasta do cliente
 * 2.1.0 - Movimentado o templateEngine para a pasta view.
 * 
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 2.1.0
 * @package core.view
 */
abstract class AbstractView
{

    protected $templates = array();
    protected $filesJS = array();
    protected $libJS = array();
    protected $filesCSS = array();
    protected $selfScript;
    protected $varsJS = '';
    protected $selfScriptPos;

    /**
     *
     * @var \core\view\CDNManager
     */
    protected $CDN;
    private $title;
    private $description;
    private $keywords;
    private static $render = false;

    /**
     *
     * @var \core\view\MensagemSistema
     */
    private $mensagemSistema;

    /**
     *
     * @var \core\libs\templateEngine\TemplateEngine
     */
    private $renderEngine;

    public function __construct()
    {
        $this->templates = array();
        $this->selfScript = '';
        $this->renderEngine = new core\view\templateEngine\TemplateEngine();
        $this->CDN = new core\view\CDNManager();
        $this->mensagemSystem();
        $this->CDN->build();
        $this->baseJs();
        $this->attValue('BASE_URL', BASE_URL);
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function addTemplate($template)
    {
        $this->templates[] = $template . '.tpl';
    }

    /**
     *
     * @return core\view\CDNManager
     */
    public function CDN()
    {
        return $this->CDN;
    }

    public function addComponente(Componente $c)
    {
        $c->setView($this);
        $c->add();
    }

    public function addSelfScript($script, $posLibs = false)
    {
        $nl = DEBUG ? PHP_EOL: '';
        if ($posLibs) {
            $this->selfScriptPos .= $script . $nl; 
        } else {
            $this->selfScript .= $script . $nl;
        }
    }

    /**
     * 
     * @param type $css
     * @deprecated since version 2.0
     */
    public function addLibCSS($css)
    {
        $this->addCSS($css);
    }

    public function addLibJS($js)
    {
        $path = DEBUG ? '/js/debug/' : '/js/dist/';
        $this->libJS[$js] = $path . $js;
    }

    public function addCSS($css)
    {
        
        $this->filesCSS[$css] =  $css;
    }

    public function addJS($js)
    {
        $path = DEBUG ? '' : 'dist/';
        $this->filesJS[$js] = $path . $js;
    }

    /**
     * Método que seta os valores das variaveis do Template a ser carregado pelo visualizador.
     *
     * @param String  $variavel = Nome da variavel que será setada
     * @param "object"  $valor = Valor para setar variável.     *
     */
    public function attValue($variavel, $valor)
    {
        return $this->renderEngine->assign($variavel, $valor);
    }

    /**
     * Método que seta os valores das variaveis do Template a ser carregado pelo visualizador.
     *
     * @param String  $variavel = Nome da variavel que será setada
     * @param "object"  $valor = Valor para setar variável.     *
     */
    public function attValueJS($variavel, $valor)
    {
        if(is_array($valor) || is_object($valor)){
            $valor = json_encode($valor);
        }else if(!is_numeric($valor)){
            $valor = '"'.$valor.'"';
        }
        $this->varsJS .=  'var '.$variavel . ' = '  . $valor . ';' .PHP_EOL;
    }

    public function render()
    {
        self::$render = true;
        $this->attDefault();
        $this->show(CORE . 'view/templates/generic/header.tpl');
        $this->mostrarTemplatesNaTela();
        $this->show(CORE . 'view/templates/generic/footer.tpl');
    }

    public function renderAjax()
    {
        self::$render = true;
        $this->mostrarTemplatesNaTela();
    }

    public function isRender()
    {
        return self::$render;
    }

    public function setRenderizado($renderizado = true)
    {
        self::$render = $renderizado;
    }

    /**
     * Método que mostra na tela o template adicionado em endereço
     *
     * @param String  $endereco = Endereco fisico do arquivo a ser aberto.
     */
    public function show($endereco)
    {
        try {
            $this->renderEngine->display($endereco);
        } catch (SmartyException $e) {
            $erro = new ErrorHandler();
            $erro->logarExcecao($e);
        }
        return;
    }
    
        /**
     * Método que retorna uma string com o resultado dos templates processados.
     * 
     * @return String página com as variáveis processadas
     */
    public function resultAsString(){
        $strResult = '';
        if (sizeof($this->templates) > 0) {
            foreach ($this->templates as $template) {
                $strResult .= $this->renderEngine->fetch($template);
            }
        }
        return $strResult;
    }

    public function startForm($action, $id='formPrincipal')
    {
        $this->addTemplate(CORE . 'view/templates/generic/start_form');
        $this->addLibCSS('componentes/forms');
        $this->attValue('action', $action);
    }

    public function endForm()
    {
        $this->addTemplate(CORE . 'view/templates/generic/end_form');
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
        return $this;
    }

    public function addMensagemErro($mensagem)
    {
        $this->mensagemSistema->setTipoMensagem('ERRO');
        $this->mensagemSistema->setMensagem($mensagem);
    }

    /**
     * 
     * @param unknown $erro
     */
    public function addErro($erro)
    {
        $this->mensagemSistema->addErro($erro);
    }

    public function addMensagemSucesso($mensagem)
    {
        $this->mensagemSistema->setTipoMensagem('SUCESSO');
        $this->mensagemSistema->setMensagem($mensagem);
    }

    public function addErros($erro)
    {
        $this->mensagemSistema->setTipoMensagem('ERRO');
        if (is_array($erro)) {
            $this->mensagemSistema->setMensagem('Os seguintes erros necessitam da sua atenção.');
            $this->mensagemSistema->addListaErro($erro);
        } else {
            $this->mensagemSistema->addErro($erro);
        }
    }

    /**
     * Método que mostra todos os templates que estão no Buffer de templates.
     */
    private function mostrarTemplatesNaTela()
    {
        if (sizeof($this->templates) > 0) {
            foreach ($this->templates as $template) {
                $this->show($template);
            }
        }
    }

    private function attDefault()
    {
        $this->attValue('TITLE', $this->title);
        $this->attValue('DESCRIPTION', $this->description);
        $this->attValue('KEYWORDS', $this->keywords);
        $this->attCDN();
        $this->attCSS();
        $this->attJS();
    }

    private function attCSS()
    {
        $this->attValue('filesCSS', $this->filesCSS);
    }

    private function attJS()
    {
        $this->attValue('libsJS', $this->libJS);
        $this->attValue('scripts', $this->filesJS);
        $this->attValue('selfScript', $this->varsJS . PHP_EOL . $this->selfScript);
        $this->attValue('selfScriptPos', $this->selfScriptPos);
    }

    private function attCDN()
    {
        $this->attValue('CDN', $this->CDN);
    }

    private function mensagemSystem()
    {
        $this->mensagemSistema = new core\view\MensagemSistema();
        $this->attValue('MSG', $this->mensagemSistema);
        $this->attValue('MSG_FILE', CORE . 'view/templates/generic/message.tpl'); //Variável para dar include do template
    }
    
    private function baseJs(){
        $this->CDN()->add('jquery');
        $this->addLibJS('enyalius/main');
    }
    
    

}
