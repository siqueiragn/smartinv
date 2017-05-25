<?php

/**
 * Description of Configuracao
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 */
class ConfiguracaoGerador
{

    private $gerarBanco = true;
    private $usuarioBanco = '';
    private $senhaBanco = '';
    private $banco = '';
    private $esquemas = '';
    private $autor = 'Marcio Bigolin';
    private $emailAutor = 'marcio.bigolinn@gmail.com';
    private $macroSistema = '';
    private $rewrite = true;
    private $deletar = true;
    private $internacionalizacao = true;
    private $urlAdicional = false;
    private $mapearImagens = true;
    private $admin = false;

    public function __construct()
    {
        $this->usuarioBanco = DB_USER;
        $this->senhaBanco = DB_PASSWORD;
        $this->banco = DB_NAME;
    }

    public function isGerarBanco()
    {
        return $this->gerarBanco;
    }

    public function getGerarBanco()
    {
        if ($this->gerarBanco) {
            return ' checked="checked" ';
        }
        return '';
    }

    public function getUsuarioBanco()
    {
        return $this->usuarioBanco;
    }

    public function getSenhaBanco()
    {
        return $this->senhaBanco;
    }

    public function getBanco()
    {
        return $this->banco;
    }

    public function getEsquemas()
    {
        return $this->esquemas;
    }

    public function getAutor()
    {
        return $this->autor;
    }

    public function getEmailAutor()
    {
        return $this->emailAutor;
    }

    public function getMacroSistema()
    {
        return $this->macroSistema;
    }
    
    public function isAdmin()
    {
        return $this->admin;
    }

    public function setAdmin($admin)
    {
        $this->admin = $admin;
        return $this;
    }

    
    public function isRewrite()
    {
        return $this->deletar;
    }

    public function getRewrite()
    {
        if ($this->rewrite) {
            return ' checked="checked" ';
        }
        return '';
    }

    public function isDeletar()
    {
        return $this->deletar;
    }

    public function getDeletar()
    {
        if ($this->deletar) {
            return ' checked="checked" ';
        }
        return '';
    }

    public function getUrlAdicional()
    {
        return $this->urlAdicional;
    }

    public function isInternacionalizacao()
    {
        return $this->internacionalizacao;
    }

    public function getIntercionalizacao()
    {
        if ($this->internacionalizacao) {
            return ' checked="checked" ';
        }
        return '';
    }

    public function setGerarBanco($gerarBanco)
    {
        if (isset($gerarBanco) && !empty($gerarBanco)) {
            $this->gerarBanco = true;
        } else {
            $this->gerarBanco = false;
        }
        return $this;
    }

    public function setUsuarioBanco($usuarioBanco)
    {
        $this->usuarioBanco = $usuarioBanco;
        return $this;
    }

    public function setSenhaBanco($senhaBanco)
    {
        $this->senhaBanco = $senhaBanco;
        return $this;
    }

    public function setBanco($banco)
    {
        $this->banco = $banco;
        return $this;
    }

    public function setEsquemas($esquemas)
    {
        $this->esquemas = $esquemas;
        return $this;
    }

    public function setAutor($autor)
    {
        $this->autor = $autor;
        return $this;
    }

    public function setEmailAutor($emailAutor)
    {
        $this->emailAutor = $emailAutor;
        return $this;
    }

    public function setMacroSistema($macroSistema)
    {
        $this->macroSistema = $macroSistema;
        return $this;
    }

    public function setRewrite($rewrite)
    {
        $this->rewrite = $rewrite;
        return $this;
    }

    public function setDeletar($deletar)
    {
        if (!isset($deletar)) {
            $this->deletar = false;
        } else {
            $this->deletar = true;
        }
        return $this;
    }

    public function setUrlAdicional($urlAdicional)
    {
        $this->urlAdicional = $urlAdicional;
    }

    public function setInternacionalizacao($internacionalizacao)
    {
        if (isset($internacionalizacao) && !empty($internacionalizacao)) {
            $this->internacionalizacao = true;
        } else {
            $this->internacionalizacao = false;
        }
        return $this;
    }

}
