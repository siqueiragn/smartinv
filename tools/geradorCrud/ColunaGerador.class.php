<?php

/**
 * A classe ColunaGerador é uma extensão da classe CampoGerador que representa a 
 * coluna de uma tabela.
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0.0
 */
class ColunaGerador extends CampoGerador
{

    private $tipo = 'String';
    private $notNull = false;
    private $restricao = false;
    private $chavePrimaria = false;
    private $chaveEstrangeira = false;
    private $chaveEstrangeiraRelacao = '';
    private $valorDefault = false;
    private $geografico = false;
    private $arquivo = false;
    private $imagem = false;

    /**
     * Construtor do objeto que representa uma coluna de uma tabela do banco de 
     * dados.
     * 
     * 
     * @param String $nome
     */
    public function __construct($nome)
    {
        $this->carregaIni();
        $this->nome = $nome;
        $this->geraLabel();
        $this->geraVariavelCamelCase();
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function isNotNull()
    {
        return $this->notNull;
    }

    public function getRestricao()
    {
        return $this->restricao;
    }

    public function isChavePrimaria()
    {
        return $this->chavePrimaria;
    }

    public function isChaveEstrangeira()
    {
        return $this->chaveEstrangeira;
    }

    public function isValorDefault()
    {
        return $this->valorDefault === false ? false : true;
    }

    /**
     * Retorna qual o nome da coluna de relação da chave estrangeira
     * 
     * @return String
     */
    public function getChaveEstrangeiraRelacao()
    {
        return $this->chaveEstrangeiraRelacao;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function setNotNull($notNull)
    {
        if ($notNull == 't') {
            $this->notNull = true;
        } else {
            $this->notNull = false;
        }
    }

    public function setRestricao($restricao)
    {
        $this->restricao = $restricao;
    }

    public function setChavePrimaria($chavePrimaria)
    {
        if ($chavePrimaria == 't') {
            $this->chavePrimaria = true;
        } else {
            $this->chavePrimaria = false;
        }
    }

    public function setChaveEstrangeira($chave)
    {
        if (!empty($chave)) {
            $this->chaveEstrangeira = true;
            $this->chaveEstrangeiraRelacao = $chave;
        }
    }

    public function setValorDefault($valorDefault)
    {
        if (!empty($valorDefault)) {
            $this->valorDefault = $valorDefault;
        }
    }

    public function getTipoPHP()
    {
        if ($this->tipo == 'integer') {
            return 'Inteiro';
        } else if ($this->tipo == 'float') {
            return 'Float';
        } else if ($this->tipo == 'boolean') {
            return 'Boolean';
        } else if ($this->isGeo()) {
            return $this->geometria();
        }
        return 'String';
    }

    /**
     * Método que obriga a passar um objeto ao invés de um dado bruto para os get 
     * e seters de tipos complexos como objetos geográficos e dados.
     * 
     * @return String tipo de dado
     */
    public function getTipagem()
    {
        if ($this->isGeo()) {
            return $this->geometria() . ' ';
        }
        return '';
    }

    public function getTamanhoCampo()
    {
        if ($this->tipo == 'int4' || $this->tipo == 'float' || $this->tipo == 'integer') {
            return 40;
        } else if ($this->tipo == 'text') {
            return 80;
        }
        return 60;
    }

    public function getValidacaoPHP()
    {
        if ($this->isGeo()) {//geometry(Point,4326)
            $texto = '';
        } else {
            $texto = '         $' . $this->variavel . ' = trim($' . $this->variavel . ');' . PHP_EOL;
        }
        if ($this->notNull) {
            $texto .= '          if(empty($' . $this->variavel . ')){' . PHP_EOL;
            $texto .= "                \$GLOBALS['ERROS'][] = 'O valor informado em " . $this->label . " não pode ser nulo!';" . PHP_EOL;
            $texto .= '                return false;' . PHP_EOL;
            $texto .= '          }' . PHP_EOL;
        }
        if ($this->tipo == 'integer') {
            $texto .= '          if(!(is_numeric($' . $this->variavel . ') && is_int($' . $this->variavel . ' + 0))){' . PHP_EOL;
            $texto .= "                \$GLOBALS['ERROS'][] = 'O valor informado em " . $this->label . " é um número inteiro inválido!';" . PHP_EOL;
            $texto .= '                return false;' . PHP_EOL;
            $texto .= '          }' . PHP_EOL;
            $texto .= '          $this->' . $this->variavel . ' = $' . $this->variavel . ';' . PHP_EOL;
            $texto .= '          return true;' . PHP_EOL;
            return $texto;
        } else if ($this->tipo == 'double precision') {
            $texto .= '          $' . $this->variavel . " = str_replace(',', '.', $" . $this->variavel . ');' . PHP_EOL;
            $texto .= '          if(!is_numeric($' . $this->variavel . ')){' . PHP_EOL;
            $texto .= "                \$GLOBALS['ERROS'][] = 'O valor informado em  " . $this->label . " é um número inválido!';" . PHP_EOL;
            $texto .= '                return false;' . PHP_EOL;
            $texto .= '          }' . PHP_EOL;
            $texto .= '          $this->' . $this->variavel . ' = $' . $this->variavel . ';' . PHP_EOL;
            $texto .= '          return true;' . PHP_EOL;
            return $texto;
        } else if ($this->tipo == 'boolean') {
            $texto .= '        $campo = trim($' . $this->variavel . ');' . PHP_EOL;
            $texto .= '        if (empty($' . $this->variavel . ')) {' . PHP_EOL;
            $texto .= '              $this->' . $this->variavel . ' = false;' . PHP_EOL;
            $texto .= '              return true;' . PHP_EOL;
            $texto .= '        }' . PHP_EOL;
            $texto .= '        if ($' . $this->variavel . "== 'f') {" . PHP_EOL;
            $texto .= '              $this->' . $this->variavel . ' = false;' . PHP_EOL;
            $texto .= '              return true;' . PHP_EOL;
            $texto .= '        }' . PHP_EOL;
            $texto .= '         $this->' . $this->variavel . ' = true;' . PHP_EOL;
            $texto .= '         return true;' . PHP_EOL;
            return $texto;
        } else {
            $texto .= ( '         $this->' . $this->variavel . ' = $' . $this->variavel . ';' . PHP_EOL);
        }
        $texto .= '         return true;' . PHP_EOL;
        return $texto;
    }

    /**
     * Retorna se é um objeto do tipo geometria do banco de dados
     * @return boolean
     */
    public function isImagem()
    {
        return $this->imagem;
    }
/**
     * Retorna se é um objeto do tipo geometria do banco de dados
     * @return boolean
     */
    public function isArquivo()
    {
        return $this->arquivo;
    }

    /**
     * Retorna se é um objeto do tipo geometria do banco de dados
     * @return boolean
     */
    public function isGeo()
    {
        return $this->geografico;
    }

    public function geometria()
    {
        if (strpos($this->tipo, 'Point')) {
            return 'Point';
        } else if (strpos($this->tipo, 'MultiPolygon')) {
            return 'MultiPolygon';
        }
        return 'GeoType';
    }
    
    public function verificaObjeto(){
        $this->verificaGeometria();
        $this->verificaArquivo();
    }
    
        /**
     * Verifica se é um objeto do tipo geometria do banco de dados
     * 
     * @return boolean
     */
    private function verificaGeometria()
    {
        if (strpos($this->tipo, 'geometry') !== false ||
                stripos($this->tipo, 'point') !== false ||
                stripos($this->tipo, 'poligo') !== false) {
            $this->geografico = true;
            return true;
        }
        return false;
    }
    
           /**
     * Verifica se é um objeto do tipo geometria do banco de dados
     * 
     * @return boolean
     */
    private function verificaArquivo()
    {
        if (strpos($this->nome, 'imagem') !== false ){
            $this->arquivo = $this->imagem =  true;
        }else if ( stripos($this->nome, 'arquivo') !== false ||
                $this->tipo == 'oid' || $this->tipo == 'bytea') {
            $this->arquivo = true;
            return true;
        }
        return false;
    }

    public function __toString()
    {
        return $this->nome;
    }

}
