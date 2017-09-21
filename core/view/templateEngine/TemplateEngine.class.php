<?php

namespace core\view\templateEngine;

/**
 * Classe que gerencia a biblioteca de templates no caso o Smarty.
 * 
 * 2.0.0 - LoadLocalPlugins adicionado
 * 
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 2.0.0
 */
class TemplateEngine extends \Smarty
{

    public function __construct($cache = false)
    {
        parent::__construct();
        $this->loadLocalPlugins();
        $this->muteExpectedErrors();
        $this->setTemplateDir(TEMPLATES);
        $this->setCompileDir(CACHE . 'templates_c/');
        $this->setConfigDir(CACHE . 'configs/');
        $this->setCacheDir(CACHE . 'cache/');
        $this->caching = $cache;
        if(!defined('TEMPLATES_CORE')){
            define('TEMPLATES_CORE', CORE . '/view/templates/');
        }
    }

    public function deploy()
    {
        echo '<p>' . $this->template_dir . '</p>';
        echo '<p>' . $this->compile_dir . '</p>';
        echo '<p>' . $this->config_dir . '</p>';
        echo '<p>' . $this->cache_dir . '</p>';
        echo '<p>' . $this->caching . '</p>';
    }

    private function loadLocalPlugins()
    {
        $path = __DIR__ . "/smartyPlugin/";
        $diretorio = dir($path);

        while ($arquivo = $diretorio->read()) {
            if($arquivo == '.' || $arquivo == '..' || is_dir($path.$arquivo) ){
                continue;
            }
            $name = str_replace('.php', '', $arquivo);
            $func = 'smarty_function_' . $name;
            if(function_exists($func)){
                continue;
            }
            require $path .  $arquivo;
            $this->registerPlugin('function', $name, $func);
        }
        $diretorio->close();
    }

    public function ativaDebug()
    {
        $this->debugging = true;
    }

}
