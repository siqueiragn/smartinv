<?php

namespace core\view;

/**
 * Classe que armazena os textos que aparecerão nas mensagens do
 * sistema.
 * 
 * A classe tem por função controlar o tipo da mensagem, se é um erro, 
 * uma mensagem de sucesso e etc. Além disso ela armazena as mensagens que 
 * irão aparecer inclusive um array de erros.
 * 
 * @author Marcio Bigolin
 * @package core.view
 * @version 11/05/2010
 */
class MensagemSistema
{

    private $ativa = false;
    private $lista = array();
    private $tipoMensagem = 'alert-info';
    private $mensagem = '';

    public function __construct()
    {
       
    }

    /**
     * 
     * @param String $erro Mensagem de erro
     */
    public function addErro($erro)
    {
        $this->ativa = true;
        $this->lista[] = $erro;
    }

    public function addListaErro($lista)
    {
        $this->addErro('Multiplos erros');
        if (count($lista) > 0) {
            $this->ativa = true;
            if (count($this->lista) > 0) {
                $this->lista = array_merge($this->lista, $lista);
            } else {
                $this->lista = $lista;
            }
        }
    }

    public function setMensagem($mensagem)
    {
        $this->ativa = true;
        $this->mensagem = $mensagem;
    }

    public function getMensagem()
    {
        return $this->mensagem;
    }

    public function getErros()
    {
        return $this->lista;
    }

    public function getAlertas()
    {
        return $this->listaAlertas;
    }

    public function isAtiva()
    {
        return $this->ativa;
    }
    
    public function getContent(){
        $str = '<p>' . $this->getMensagem() . '</p>';
        if (sizeof($this->lista)) {
            $str .= '<ul>';
            foreach ($this->lista as $erro) {
                $str .= '<li>' . $erro . '</li>';
            }
            $str .= '</ul>';
        }

        return $str;
    }

    public function setTipoMensagem($tipoMensagem)
    {
        $tipoMensagem = strtoupper($tipoMensagem);
        if ($tipoMensagem == 'ERRO') {
            $this->tipoMensagem = 'alert-danger';
        } else if ($tipoMensagem == 'SUCESSO') {
            $this->tipoMensagem = 'alert-success';
        } else if ($tipoMensagem == 'ALERTA') {
            $this->tipoMensagem = 'alert-waring';
        } else {
            $this->tipoMensagem = 'alert-info';
        }
    }

    public function getTipoMensagem()
    {
        return $this->tipoMensagem;
    }

    /**
     * 
     * @return boolean true se existir alguma mensagem no buffer
     */
    public function isValida()
    {
        if ($this->mensagem != false || $this->ativa == true) {
            return true;
        } else {
            return false;
        }
    }

}
