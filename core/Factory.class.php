<?php

/**
 * A classe Factory contem o script responsável por instanciar os objetos
 * e executar a ação solicitada, pela URL.
 *
 * #TODO - Implementar um forçar https #1
 * #TODO - Implementar um debug
 * #TODO - implementar um diagrama de atividades para essa classe issue #5
 * #TODO - Verificar a performance desse carrinha
 * #TODO - Redirect via session #22
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.1
 * @package core
 */
class Factory
{

    private $url;
    //private $debug = false;
    private $acao = 'index';
    private $control;
    private $path = 'control';
    private $protocolo = 'http';

    public function __construct()
    {
        $url = filter_var($_SERVER['REQUEST_URI']);//Manter assim bug apache se usar filter_input
        $this->url = preg_replace('[^aA-zZ/0-9çãõéíóáúêô?&]', '', urldecode($url));
        $protocolo = $_SERVER['SERVER_PORT']  == 443? 'https' : 'http';
        $this->protocolo = $protocolo;
        require_once(CORE . 'autoload.php');
        $this->baseUrl();
    }

    public function start()
    {
        $this->geraAcao();
    }

    /**
     * Método que tranforma a requisicao em HTTPS
     */
    public function toHTTPS()
    {
        #TODO verificar se já esta em https e caso não estiver trocar o estatus
    }

    public function geraAcao()
    {
        $url = $this->removeArgs($this->url); 
        $GLOBALS['URL'] = $url;
        if ($this->searchControl($url)) {
            require_once $this->path. '/'. $this->control . '.class.php';
            $c = $this->control;
            $controlador = new $c();            
        } 
        if(!isset($controlador)){
            require_once ROOT . 'control/ControladorGeral.class.php';
            $controlador = new ControladorGeral();
        }
        if (method_exists($controlador, $this->acao)) {
            return $controlador->{$this->acao}();
        }
        return $controlador->paginaNaoEncontrada();
    }

    private function searchControl($url)
    {
        $pieces = explode('/', $url);
        $this->defineAcao($pieces, 0);
        $path = ROOT . 'control';
        for ($i = 1; $i < sizeof($pieces); $i++) {
            if (is_dir($path . '/' . $pieces[$i])) {
                $path .= '/' . $pieces[$i];
            } else if (file_exists($path . '/Controlador' . ucfirst($pieces[$i]) . '.class.php')) {
                $this->control = 'Controlador' . ucfirst($pieces[$i]);
                $this->path = $path;
                $this->defineAcao($pieces, $i);
                return true;
            }
        }
        return false;
    }

    private function defineAcao($pieces, $i)
    {
        if (isset($pieces[$i + 1]) && !empty($pieces[$i + 1])) {
            $this->acao = $pieces[$i + 1];
            $GLOBALS['ARGS'] = array_slice($pieces, $i + 2);
        } else {
            $this->acao = 'index';
        }
    }

    private function removeArgs($url)
    {
        $tamanhoUrl = strpos($url, '?') ? strpos($url, '?') : strlen($url);
        return substr($url, 0, $tamanhoUrl);
    }
  
    private function baseUrl()
    {
        $urlBase = $this->protocolo . '://' . filter_input(INPUT_SERVER, 'SERVER_NAME');

        if (!defined('BASE_URL')) {
            define('BASE_URL', $urlBase);
        }
    }

}
