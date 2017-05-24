<?php

/**
 * Classe que implementa os métodos e configurações necessárias para o sistema de erro
 * dos sistemas.
 * 
 * 1.2.0 - Printando back trace
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.2.0 - 2014-12-15
 */
class ErrorHandler {

    private static $logarBanco = true;
    private static $enviarEmail = true;
    private static $salvarArquivo = true;
    private static $enderecoArquivoLog = true;
    private $errorLog;
    private $errosSistema = '';    
    private $ocultarNotices = false;
    public static $exit = false;

    /**
     * 
     * @param Exception $e
     */
    public function logarExcecao($e) {
        list($severidade, $sair) = ErrorHandler::nivelErro($e);
        $this->errorLog = $this->geraString($e, $severidade);
        
        if (DEBUG == true) {
            $this->errosSistema = $this->geraHtml($e, $severidade);
        } else {
            $this->mandarEmail($e->getMessage(), $e->getTraceAsString());
        }
        if($sair && DEBUG){                     
            exit();
        }else if($sair){
            header('Location: '. ERROR_PAGE);
        }     
    }

    public static function mandarEmail($erro, $e) {
        if (isset($GLOBALS['EMAILS_PROGRAMADORES'])) {
            $emails = $GLOBALS['EMAILS_PROGRAMADORES'];
            MailUtil::sendMail($GLOBALS['MAIL_CONFIG']['FROM'], $emails, '[SYSTEM] - ' . $erro, $e);            
        } else {
            MailUtil::sendMail($GLOBALS['MAIL_CONFIG']['FROM'], 'marcio.bigolinn@gmail.com', '[UNCONFIGURED-SYSTEM] - ' . $erro, $e);
        }
        include(ROOT . 'erro.php');
    }  
    
    public function getOcultarNotices() {
        return $this->ocultarNotices;
    }

    public  function setOcultarNotices($ocultarNotices) {
        $this->ocultarNotices = $ocultarNotices;
    }
    
    private function geraString($e, $severidade){
        $string  =  '[' . $severidade. '][MENSAGEM] =' . $e->getMessage() . PHP_EOL;
        $string .=  '                    [ONDE] = ' .$e->getFile(). ', linha' . $e->getLine() . PHP_EOL. PHP_EOL;
        return $string;
    }
    
    private function geraHtml($e, $severidade) {
        $html = '<div style="text-align: center;">';
        $html .= '  <h2 style="color: rgb(190, 50, 50);">Erro não tratado:</h2>';
        $html .= '  <table style="width: 800px; display: inline-block;">';
        $html .= "<tr style='background-color:rgb(230,230,230);'><th style='width: 80px;'>Capturado por</th><td>" . get_class($e) . "</td></tr>";
        $html .= "<tr style='background-color:rgb(230,230,230);'><th style='width: 80px;'>Tipo </th><td>" . $severidade . "</td></tr>";
        $html .= "<tr style='background-color:rgb(240,240,240);'><th>Mensagem</th><td>{$e->getMessage()}</td></tr>";
        $html .= "<tr style='background-color:rgb(230,230,230);'><th>Arquivo</th><td>{$e->getFile()}</td></tr>";
        $html .= "<tr style='background-color:rgb(240,240,240);'><th>Linha</th><td>{$e->getLine()}</td></tr>";
        $html .= '<tr style="background-color:rgb(240,240,240);"><th>Pilha</th><td><pre style="text-align: left;">' . $e->getTraceAsString() . '</pre></td></tr>';
        if (get_class($e) == 'SQLException') {
            $html .= '<tr style="background-color:rgb(240,240,240);"><th>SQL</th><td><pre style="text-align: left;">' . $e->getQuery() . '</pre></td></tr>';
        }
        $html .= '</table></div>' . PHP_EOL;
        return $html;
    }

    private static function logarEmArquivo() {
        
    }

    private static function nivelErro($e) {
        $severidade = method_exists($e, 'getSeverity') ? $e->getSeverity() : -1;
        // Para saber mais sobre os tipos de erros que o PHP gera ver
        // http://php.net/manual/pt_BR/errorfunc.constants.php
        $exit = false;
        switch ($severidade) {
            case -1: //Exceção simples
                $type = 'Exception';
                break;
            case E_USER_ERROR:
                $type = 'Fatal Error';
                $exit = true;
                break;
            case E_USER_WARNING:
            case E_WARNING:
                $type = 'Warning';
                break;
            case E_USER_NOTICE:
            case E_NOTICE:
            case E_STRICT:
                $type = 'Notice';
                break;
            case E_RECOVERABLE_ERROR:
                $type = 'Catchable';
                break;
            case E_PARSE:
            case E_USER_DEPRECATED:
            case E_COMPILE_WARNING: 
                $type = 'Sintax Error';
                $exit = true;
                break;
            default:
                $type = 'Unknown Error';
                $exit = true;
                break;
        }

        return array($type, $exit);
    }
    
    public function __destruct() {
        if(DEBUG){
           $msgsErro  = '<div class="errosDEBUG">' . $this->errosSistema . '</div>';
           $msgsErro .= '<div class="consoleDEBUG" style="display:none">'. PHP_EOL ;
           $msgsErro .=        '*****'. PHP_EOL . $this->errorLog . PHP_EOL. '****</div>';
           echo $msgsErro;
        }
        if(ErrorHandler::$exit){
            exit();
        }
    }

}
