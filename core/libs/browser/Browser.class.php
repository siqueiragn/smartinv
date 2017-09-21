<?php

/**
 * Classe que permite navegar em outros sistemas.
 * 
 * @autor Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0.0
 */
class Browser
{

    /**
     * @var CurlResourse
     */
    private $ch;
    private $options;
    private $requestArgs;
    private $header;
    private $result;
    private $body;
    private $cookieFile;
    private $cookies = array();
    private $url = false;
    private $debug = true;

    /**
     * 
     * @param EnderecoCookieFile $cookieFile
     * @throws Exception
     */
    public function __construct($cookieFile = false)
    {
        $this->cookieFile = $cookieFile ? $cookieFile : $this->geraArquivoCookie();

        $this->ch = curl_init();

        if (FALSE === $this->ch) {
            throw new Exception('failed to initialize');
        }
        $this->options();
    }

    public function requisita($url = false)
    {

        if (!empty($url)) {
            $this->setUrl($url);
        }
        $this->enviaCookies();
        curl_setopt_array($this->ch, $this->options);
        $result = utf8_decode(curl_exec($this->ch));
        if (FALSE === $result) {
            throw new Exception(curl_error($this->ch), curl_errno($this->ch));
        }

        $headerSize = curl_getinfo($this->ch, CURLINFO_HEADER_SIZE);
        $this->header = substr($result, 0, $headerSize);
        $this->result = substr($result, $headerSize+1, strlen($result) - $headerSize - 1);
    }

    /**
     * Array chave valor de variaveis do tipo post.
     * 
     * @param Array $array
     */
    public function setRequestArray($array)
    {
        $this->options[CURLOPT_POSTFIELDS] = $array;
    }

    public function setUrl($url)
    {
        /* if(filter_var($url, FILTER_SANITIZE_URL)){
          throw new Exception("URL Inválida", 1);
          } */
        $this->url = $url;
        $this->options[CURLOPT_URL] = $url;
    }

    public function getBodyCode()
    {
        return htmlspecialchars($this->result, ENT_QUOTES | ENT_SUBSTITUTE, 'utf-8');
    }

    public function getHeader()
    {
        return $this->header;
    }

    /**
     * 
     * @return String
     */
    public function getResult()
    {
        return $this->result;
    }

    public function imprimeHeader($fonte = true)
    {
        if (!$this->header) {
            $this->requisita();
        }
        $result = $this->header;
        if ($fonte) {
            echo '<pre>', $result, '</pre>';
            return;
        }
        echo $result;
    }

    public function imprimeBody($fonte = true)
    {
        if (!$this->result) {
            $this->requisita();
        }
        $result = $this->result;
        if ($fonte) {
            $r = htmlspecialchars($result, ENT_QUOTES | ENT_SUBSTITUTE, 'utf-8');
            echo '<pre>', $r, '</pre>';
            return;
        }
        echo $result;
    }

    public function enviaCookies()
    {
        if (count($this->cookies)) {
            curl_setopt($this->ch, CURLOPT_COOKIE, implode('; ', $this->cookies));
        }
    }

    public function getCookieFile()
    {
        return $this->cookieFile;
    }

    public function setCookieFile($cookieFile)
    {
        $this->cookieFile = $cookieFile;
    }

    public function setCookie($chave, $valor)
    {
        $this->cookies[] = $chave . '=' . $valor;
    }

    private function geraArquivoCookie()
    {
        return '/tmp/cookie' . md5(uniqid()) . '.txt';
    }

    private function options()
    {
        $headers = array("Content-Type:multipart/form-data",
            'Connection: keep-alive'
        ); // cURL headers for file uploading

        $agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:43.0) Gecko/20100101 Firefox/43.0';

        $this->options = array(
            CURLOPT_HEADER => true,
            CURLINFO_HEADER_OUT => 1,
            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_VERBOSE => 1,
            CURLOPT_COOKIEFILE => $this->cookieFile,
            CURLOPT_COOKIEJAR => $this->cookieFile,
            CURLOPT_COOKIESESSION => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_USERAGENT => $agent,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_UNRESTRICTED_AUTH => 1
        );
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }

}
