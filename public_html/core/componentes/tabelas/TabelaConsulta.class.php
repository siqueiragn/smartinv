<?php

/**
 * 
 */
class TabelaConsulta {

    private $pagina;
    private $rePaginar;
    private $ordenarCampo;
    private $ordem;
    private $pesquisa;
    private $pesquisaCampo;
    private $pesquisaCampoTipo;
    private $restricaoExtra;
    private $realizarPesquisa;

    public function __construct($ordenarCampo, $ordem = 'ASC') {

        $this->setOrdem($ordem);
        $this->setOrdenarCampo($ordenarCampo);

        $this->pagina = 1;
        $this->rePaginar = 10;
        $this->pesquisa = false;
        $this->pesquisaCampo = false;
        $this->restricaoExtra = '';
    }

    public function recebeDados($post) {
        if (isset($_POST['rows'])) {
            $this->setRePaginar($_POST['rows']);
            $this->setOrdem($_POST['sord']);
            $this->setRealizarPesquisa($_POST['_search']);
        } else {
            $this->setRePaginar($_POST['rp']);
            $this->setOrdem($_POST['sortorder']);
            $this->setPesquisa($_POST['query']);
            $this->setPesquisaCampo($_POST['qtype']);
        }
        $this->setPagina($_POST['page']);
    }

    public function getPagina() {
        return $this->pagina;
    }

    public function setPagina($pagina) {
        $this->pagina = ValidatorUtil::variavelInt($pagina);
    }

    /**
     * 
     * @return int Quantidade de itens na pagina para repaginar
     */
    public function getRePaginar() {
        return $this->rePaginar;
    }

    /**
     * Quantidade de itens necessários para realizar a quebra de página.
     * 
     * @param Int $rePaginar
     */
    public function setRePaginar($rePaginar) {
        $this->rePaginar = ValidatorUtil::variavelInt($rePaginar);
    }

    public function getOrdenarCampo() {
        return $this->ordenarCampo;
    }

    public function setOrdenarCampo($ordenarCampo) {
        $ordenarCampo = ValidatorUtil::variavel($ordenarCampo);
        if ($ordenarCampo == 'undefined' || empty($ordenarCampo)) {
            $ordenarCampo = 'principal';
        }
        $this->ordenarCampo = $ordenarCampo;
    }

    public function getOrdem() {
        return $this->ordem;
    }

    public function setOrdem($ordem) {
        $ordem = ValidatorUtil::variavel($ordem);
        $ordem = strtoupper($ordem);
        if ($ordem != 'DESC') {
            $this->ordem = 'ASC';
        } else {
            $this->ordem = 'DESC';
        }
    }

    public function getPesquisa() {
        return $this->pesquisa;
    }
    
    public function calculaPaginacao($count) {
        if ($count > 0) {
            return ceil($count / $this->rePaginar);
        } else {
            return 0;
        }
    }

    /**
     * 
     * @param type $pesquisa - valor para realizar a pesquisa
     */
    public function setPesquisa($pesquisa) {
        $pesquisa = ValidatorUtil::variavel($pesquisa);
        $this->realizarPesquisa = true;
    }

    public function getPesquisaCampo() {
        return $this->pesquisaCampo;
    }

    public function setPesquisaCampo($pesquisaCampo) {
        $campo = ValidatorUtil::variavel($pesquisaCampo);
        $campos = explode('#', $pesquisaCampo);
        $this->pesquisaCampo = $campos[0];
        if (isset($campos[1])) {
            $this->pesquisaCampoTipo = $campos[1];
        } else {
            $this->pesquisaCampoTipo = 'string';
        }
    }

    public function getOrdenacao() {
        return $this->ordenarCampo . ' ' . $this->ordem;
    }

    /**
     * Método que retorna o valor da variável realizarPesquisa
     *
     * @return String - Valor da variável realizarPesquisa
     */
    public function getRealizarPesquisa() {
        return $this->realizarPesquisa;
    }

    /**
     * Método que seta o valor da variável realizarPesquisa
     *
     * @param String $realizarPesquisa - Valor da variável realizarPesquisa
     */
    public function setRealizarPesquisa($realizarPesquisa) {
        $realizarPesquisa = trim($realizarPesquisa);
        if ($realizarPesquisa == 'false') {
            $this->realizarPesquisa = false;
        } else {
            $this->realizarPesquisa = true;
        }
        return true;
    }

    /**
     * Método que monta a condição da query como restrição, oredenação quantidade
     * de resultados
     * 
     * @return String - Condição para a query
     */
    public function getcondicao() {
        $ordenacao = ' ORDER BY ' . $this->ordenarCampo . ' ' . $this->ordem;
        $inicio = (($this->pagina - 1) * $this->rePaginar);

        $limite = ' LIMIT ' . $this->rePaginar . ' OFFSET ' . $inicio;

        $consulta = ' ';
        if ($this->realizarPesquisa) {
            $consulta .= ' WHERE ';
            if(isset($_POST['filters'])){
                $filtros = json_decode($_POST['filters']);
                $agrup = $filtros->groupOp;
                $flag = 0;
                foreach ($filtros->rules as $campo){  
                    $campo->type = $_SESSION['coluna'.$campo->field];
                    if(!$flag){
                        $consulta .= $this->consulta($campo->field, $campo->data, 
                                                $campo->type, $campo->op);
                        $flag = 1;
                    }else{
                        $consulta .= $agrup . ' '. $this->consulta($campo->field, $campo->data, 
                                                $campo->type, $campo->op);

                    }
                }
                if (!empty($this->restricaoExtra)) {
                    $consulta .= 'AND ';
                 }
            }
            if (!empty($this->restricaoExtra)) {
                $consulta .= '(' . $this->restricaoExtra . ')';
            }
        } else if (!empty($this->pesquisa)) {
            if ($this->pesquisaCampoTipo == 'int4' || 
                    $this->pesquisaCampoTipo == 'float8' ||
                    $this->pesquisaCampoTipo == 'numeric') {
                $consulta = ' WHERE (' . $this->pesquisaCampo . '=' . $this->pesquisa . ')';
            } else if ($this->pesquisaCampoTipo == 'time' || $this->pesquisaCampoTipo == 'timestamp') {
                $consulta = ' WHERE (' . $this->pesquisaCampo . "= '" . strtotime($this->pesquisa) . "')";
            } else if ($this->pesquisaCampoTipo == 'bool') {
                $pes = trim($this->pesquisa);
                $pes = strtolower($pes);
                if ($pes == 'true' || $pes == 'verdadeiro' || $pes == 'existe') {
                    $pes = 'T';
                }else{
                    $pes = 'F';
                }
                $consulta = ' WHERE (' . $this->pesquisaCampo . "= '" . $pes . "')";
            } else {
                $consulta = ' WHERE translate(' . $this->pesquisaCampo;
                $consulta .= ",'áéíóúàèìòùãõâêîôôäëïöüçÁÉÍÓÚÀÈÌÒÙÃÕÂÊÎÔÛÄËÏÖÜÇ',";
                $consulta .= " 'aeiouaeiouaoaeiooaeioucAEIOUAEIOUAOAEIOOAEIOUC') ILIKE ";
                $consulta .= "translate('%" . $this->pesquisa . "%' , ";
                $consulta .= "'áéíóúàèìòùãõâêîôôäëïöüçÁÉÍÓÚÀÈÌÒÙÃÕÂÊÎÔÛÄËÏÖÜÇ', ";
                $consulta .= "'aeiouaeiouaoaeiooaeioucAEIOUAEIOUAOAEIOOAEIOUC') ";
            }

            if (!empty($this->restricaoExtra)) {
                $consulta .= 'AND (' . $this->restricaoExtra . ')';
            }
        } else {
            if (!empty($this->restricaoExtra)) {
                $consulta = ' WHERE (' . $this->restricaoExtra . ')';
            }
        }
        
        return $consulta . $ordenacao . $limite;
    }

    public function restricaoExtra($restricao) {
        $this->restricaoExtra = $restricao;
    }

    /**
     *
     * @param type $campo
     * @param type $valor
     * @param type $tipo
     * @param type $operador
     * @return String Condição de pesquisa
     */
    private function consulta($campo, $valor, $tipo = 'string', $operador = 'eq') {
        if (    $tipo == 'int4' || $tipo == 'integer' || 
                $tipo == 'float8' || $tipo == 'double' ||
                $tipo == 'int' || $tipo == 'float' || $tipo == 'numeric') {
            $operador = $operador == 'bw'?'eq':$operador;
            $operador = $operador == 'cn'?'eq':$operador; 
            $operador = $operador == 'bw'?'eq':$operador;
            $operador = $this->operador($operador);            
            return  '(' . $campo . $operador . $valor . ')';
        } else if ($tipo == 'time' || $tipo == 'timestamp') {
            return '(' . $campo . "= '" . strtotime($valor) . "')";
        } else if ($tipo == 'bool') {
            $pes = trim($valor);
            $pes = strtolower($pes);
            if ($pes == 'true' || $pes == 'verdadeiro' || $pes == 'existe') {
                $pes = 'T';
            }else{
                $pes = 'F';
            }
            return '(' . $campo . "= '" . $pes . "')";
        } else {
            if($operador == 'bw' || $operador == 'ew' || $operador == 'cn' ){
                $valor = $this->operador($operador, $valor);
                $operador = ' ILIKE ';
            }else{
                $operador = $this->operador($operador);
            }
            $consulta = 'translate(' . $campo;
            $consulta .= ",'áéíóúàèìòùãõâêîôôäëïöüçÁÉÍÓÚÀÈÌÒÙÃÕÂÊÎÔÛÄËÏÖÜÇ',";
            $consulta .= " 'aeiouaeiouaoaeiooaeioucAEIOUAEIOUAOAEIOOAEIOUC') $operador ";
            $consulta .= "translate('" . $valor. "' , ";
            $consulta .= "'áéíóúàèìòùãõâêîôôäëïöüçÁÉÍÓÚÀÈÌÒÙÃÕÂÊÎÔÛÄËÏÖÜÇ', ";
            $consulta .= "'aeiouaeiouaoaeiooaeioucAEIOUAEIOUAOAEIOOAEIOUC') ";
            return $consulta;
        }
    }

    private function operador($op, $valor='') {
        switch ($op) {
            case 'eq': return '=';
            case 'ne': return '!=';
            case 'lt': return '<';
            case 'gt': return '>'; 
            case 'le': return '<=';
            case 'ge': return '>=';
            case 'bw': return  $valor . '%';
            case 'ew': return '%' . $valor;
            case 'cn': return '%' . $valor . '%';
        }
    }

    
}