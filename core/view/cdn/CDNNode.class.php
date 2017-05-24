<?php
namespace core\view\cdn;

/**
 * Description of CDNNode
 *
 * @author Marcio Bigolin
 */
class CDNNode {
    private $sha;
    private $endereco;
    private $nome;
    private $versao;
    private $debug = false;
    private $alternative = false;

    public function __construct($object  = false) {
        if(is_array($object)){
            $this->processaJson($object);
        }else{
          $this->endereco = $object;
        }
    }

    public function getSha() {
        return $this->sha;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getVersao() {
        return $this->versao;
    }

    public function getDebug() {
        return $this->debug;
    }

    public function getAlternative() {
        return $this->alternative;
    }

    public function setSha($sha) {
        $this->sha = $sha;
        return $this;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
        return $this;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    public function setVersao($versao) {
        $this->versao = $versao;
        return $this;
    }

    public function setDebug($debug) {
        $this->debug = $debug;
        return $this;
    }

    public function setAlternative($alternative) {
        $this->alternative = $alternative;
        return $this;
    }

    #TODO Implementar o parser de CDN ISSUE #6
    public function processaJson($obj){
        if(isset($obj['cdn'])){
            $this->setEndereco($obj['cdn']);
            if(isset($obj['sha'])){
                $this->setSha($obj['sha']);
            }
        }else{
            throw new \InvalidArgumentException('O CDN ' . $obj . ' é inválido' );
        }
    }

    public function __toString() {
        return $this->endereco;
    }

}
