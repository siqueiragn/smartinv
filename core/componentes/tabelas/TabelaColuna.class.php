<?php
/**
 * Classe que constrói as colunas que serão utilizadas em uma tabela de componente 
 * do sistema. 
 * 
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version  1.0.0 10/11/2013
 */
class TabelaColuna {

    private $label;
    private $id;
    private $largura;
    private $alinhamento;
    private $ordenavel;
    private $visivel;
    private $buscaTipo;
    private $busca;
    private $congelada;

    /**
     * Construtor da classe que cria as colunas do componente de tabela do SIA
     * 
     * @param String $label - nome da coluna
     * @param String $id - identificador da coluna
     */
    public function __construct($label, $id) {
        $this->label = $label;
        $this->id = $id;
        $this->largura = '60';
        $this->alinhamento = 'left';
        $this->ordenavel = true;
        $this->visivel = true;
        $this->buscaTipo = false;
        $this->busca = false;
        $this->congelada = false;
    }

    public function getLabel() {
        return $this->label;
    }

    public function setLabel($label) {
        $this->label = $label;
    }

    public function getNome() {
        return $this->id;
    }

    public function setNome($nome) {
        $this->id = $nome;
    }

    public function getLargura() {
        return $this->largura;
    }

    public function setLargura($largura) {
        if (is_int($largura)) {
            $this->largura = $largura;
        } else {
            if (intval($largura) > 0) {
                $this->largura = intval(0);
            } else {
                $this->largura = 60;
                echo 'NOTICE: Verifique a largura da coluna ' . $this->label;
            }
        }
    }

    public function getAlinhamento() {
        return $this->alinhamento;
    }

    public function setAlinhamento($alinhamento) {
        if ($alinhamento == 'left'
                || $alinhamento == 'right'
                || $alinhamento == 'center'
                || $alinhamento == 'justify') {
            $this->alinhamento = $alinhamento;
        } else {
            echo 'NOTICE: Verifique alinhamento da coluna ' . $this->label;
        }
    }
    
    /**
     * Método que retorna o valor do campo se ordenavel
     * 
     * @return string retorno para o javascript
     */
    public function getOrdenavel() {
        if ($this->ordenavel) {
            return 'true';
        } else {
            return 'false';
        }
    }

    /**
     * Método que determina se o campo é ordenavel ou não
     * 
     * @param bool $ordenavel
     */
    public function setOrdenavel($ordenavel) {
        $this->ordenavel = $ordenavel;
    }
    
    /**
     * Método que retorna o valor do campo se congelada
     * 
     * @return string retorno para o javascript
     */
    public function getCongelada() {
        if ($this->congelada) {
            return 'true';
        } else {
            return 'false';
        }
    }

    /**
     * Método que determina se o campo é congelada ou não
     * 
     * @param bool $congelada
     */
    public function setCongelada($congelada) {
        $this->congelada = $congelada;
    }

    public function getVisivel() {
        if (!$this->visivel) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function setVisivel($visivel) {
        $this->visivel = $visivel;
    }

    /**
     * Método que retorna o valor da variável buscaTipo
     *
     * @return String - Valor da variável buscaTipo
     */
    public function getBuscaTipo() {
        return $this->buscaTipo;
    }

    /**
     * Método que seta o valor da variável buscaTipo
     *
     * @param String $buscaTipo - Valor da variável buscaTipo
     */
    public function setBuscaTipo($buscaTipo) {
        $tipo = trim($buscaTipo);
        $this->buscaTipo = $tipo;
        $this->busca = true;
        $_SESSION['coluna'. $this->id] = $tipo;
        return true;
    }

    /**
     * Método que retorna o valor da variável busca
     *
     * @return String - Valor da variável busca
     */
    public function getBusca() {
        if ($this->busca) {
            return 'true';
        } else {
            return 'false';
        }
    }

    /**
     * Método que seta o valor da variável busca
     *
     * @param String $busca - Valor da variável busca
     */
    public function setBusca($busca) {
        $this->busca = $busca;
        return true;
    }

    /**
     * Método que gera o Código fonte para ser adicionado no JS
     * 
     * @return string
     */
    public function __toString() {
        $string = 'display: "' . $this->label . '", ';
        $string .= 'name: "' . $this->id . '", ';
        $string .= 'id: "' . $this->id . '", ';
        $string .= 'width: ' . $this->largura . ', fixed: true, ';
        $string .= 'align: "' . $this->alinhamento . '", ';
       
        if ($this->busca) {
            $string .= 'search: ' . $this->getBusca() . ', ';
            $string .= 'searchrules: {}, ';
        }
        $string .= 'sortable: ' . $this->getOrdenavel() . ', ';
        $string .= 'hide: ' . $this->getVisivel();
        if($this->congelada){
             $string .= ', frozen: true';
        }
        return $string;
    }

}

