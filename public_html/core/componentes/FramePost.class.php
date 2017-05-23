<?php

/**
 * A classe FramePost cria um iframe que permite realizar requisições do tipo POST.
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @package core.componentes
 * @version 1.0.0 21/02/2016
 */
class FramePost extends Componente Implements JsonSerializable
{

    private $id;
    private $dados;
    private $url;
    private $target;

    public function __construct()
    {
        $this->id = $this->generateId();
        $this->target = 'iframe' . $this->id;
    }

    public function add()
    {
        $this->addTemplate('FramePost/frame');
        $this->view->addLibJS('componentes/framePost/main');
        $script = $this->montaScript();
        $this->view->addSelfScript($script);
        $this->view->attValue('_frame', $this);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDados()
    {
        return $this->dados;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function setDados($dados)
    {
        $this->dados = $dados;
        return $this;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function setTarget($target)
    {
        $this->target = $target;
        return $this;
    }

    public function jsonSerialize()
    {
        return array(
            'url' => $this->url,
            'target' => $this->target,
            'data' => $this->dados
        );
    }

    private function montaScript()
    {
        return '_Frame = ' . json_encode($this) . ';';
    }

}
