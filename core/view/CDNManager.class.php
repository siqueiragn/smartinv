<?php

namespace core\view;

/**
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 */
class CDNManager
{

    private $css = array();
    private $js = array();
    private $json = false;
    private $singleton = array();
    private $offline = false;

    public function __construct()
    {
        if (defined('OFFLINE')) {
            $this->offline = OFFLINE;
        }
    }

    public function build($file = null)
    {
        if ($file == null) {
            $file = $this->defineCaminho();
        }
        $this->json = json_decode(file_get_contents($file), true);
    }

    public function getCSS()
    {
        return $this->css;
    }

    public function getJs()
    {
        return $this->js;
    }
    
    public function addExtra($extra, $type = 'js'){
        if($type == 'js'){
            $this->js[] = new cdn\CDNNode($extra);
        }else{
            $this->css[] = new cdn\CDNNode($extra);
        }
    }

    public function add($lib)
    {
        if ($this->isAdd($lib)) {
            return;
            #TODO verificar o quanto prejudica a performance e se é necessário logar iiso
        }
        $this->singleton[strtolower($lib)] = 1;
        $cdnFind = 0;
        if (isset($this->json['js'][$lib])) {
            $this->js[] = $this->getCDN($lib);
            $cdnFind = 1;
        }
        if (isset($this->json['css'][$lib])) {
            $this->css[] = $this->getCDN($lib, 'css');
            $cdnFind = 1;
        }
        return $cdnFind;
    }

    public function isAdd($lib)
    {
        if (isset($this->singleton[strtolower($lib)])) {
            return true;
        }
    }

    private function defineCaminho()
    {
        return CORE . 'view/core_client/cdn.json';
    }

    /**
     *
     * @param type $libName
     * @return String URI CDN de uma biblioteca
     */
    private function getCDN($libName, $type = 'js')
    {
        if (!$this->json) {
            $this->build();
        }
        if (DEBUG && isset($this->json[$type][$libName]['debug'])) {
            return $this->cdnDebug($libName, $type);
        }
        if (isset($this->json[$type][$libName]) && !$this->offline) {
            return new cdn\CDNNode($this->json[$type][$libName]);
        } else {
            $pt = $_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http';
            return new cdn\CDNNode($pt . '://' . $_SERVER['SERVER_NAME'] . '/' . $type . '/dist/' . $libName . '/' . $libName . '.' . $type);
        }
    }

    private function cdnDebug($libName, $type = 'js')
    {
        $debug = $type == 'js' ? '/debug' : '/';
        return new cdn\CDNNode('http://' . $_SERVER['SERVER_NAME'] . '/' . $type . $debug . '/' . $libName . '/' . $libName . '.' . $type);
    }

}
