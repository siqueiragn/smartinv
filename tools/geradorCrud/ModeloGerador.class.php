<?php

/**
 * Classe responsável por gerar o modelo de dados.
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @package tools.geradorCrud
 * @version 2.0.0
 */
class ModeloGerador extends ArquivoGerador {
    private $colunas;

    public function gerar() {

        $print = '<?php' . PHP_EOL;
        $print .= PHP_EOL;
        $print .= '/**' . PHP_EOL;
        $print .= ' * Classe de modelo referente ao objeto ' . ucfirst($this->tabela->getNomeCamelCase()) . ' para ' . PHP_EOL;
        $print .= ' * a manutenção dos dados no sistema ' . PHP_EOL;
        $print .= ' *' . PHP_EOL;
        $print .= ' * @package modulos.' . lcfirst($this->getModulo()) . PHP_EOL;
        $print .= ' * @author ' . $this->config->getAutor() . ' <' . $this->config->getEmailAutor() . '>' . PHP_EOL;
        $print .= ' * @version 1.0.0 - ' . date('d-m-Y') . '(Gerado automaticamente - GC - ' . VERSAO . ')' . PHP_EOL;
        $print .= ' */' . PHP_EOL . PHP_EOL;
        $print .= 'class ' . $this->tabela->getNomeCamelCase() . 'DAO extends AbstractDAO ' . PHP_EOL .'{';
        $print .= PHP_EOL . PHP_EOL;
        $print .= '    /**' . PHP_EOL;
        $print .= '    * Construtor da classe ' . $this->nome . 'DAO esse metodo  ' . PHP_EOL;
        $print .= '    * instancia o Modelo padrão conectando o mesmo ao banco de dados' . PHP_EOL;
        $print .= '    *' . PHP_EOL;
        $print .= '    */' . PHP_EOL;
        $print .= '    public function __construct()'. PHP_EOL . '    {' . PHP_EOL;
        if ($GLOBALS['bancoPadrao']) {
            $print .= "        parent::__construct();" . PHP_EOL;
        } else {
            $print .= "        parent::__construct('" . $this->config->getBanco() . "', '" . $this->config->getUsuarioBanco() . "', '" . $this->config->getSenhaBanco() . "');" . PHP_EOL;
        }
        $print .= '    }' . PHP_EOL;
        $print .= PHP_EOL;
        $print .= '    /**' . PHP_EOL;
        $print .= '     * Método que retorna um array com a tabela dos dados de ' . $this->tabela->getLabel() . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     * @return Array tabela de dados' . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '    public function getTabela(TabelaConsulta $tabela)'. PHP_EOL . '    {' . PHP_EOL;
        $print .= '        $dados = array();' . PHP_EOL;
        $print .= "        \$nLinhasCon = \$this->queryTable('" . $this->tabela->getNomeCompleto() . "', 'count(" . reset($this->campos) . ") as num');" . PHP_EOL;
        $print .= '        $nLinhas = $nLinhasCon->fetch();' . PHP_EOL;
        $print .= "        \$result = \$this->queryTable(  '" . $this->tabela->getNomeCompleto() . " ' . \$tabela->getcondicao(), " . PHP_EOL;

        $print .= $this->getColunas() . "'" . PHP_EOL;
        $print .= '                                       );' . PHP_EOL;
        $print .= '        $resultado = array(' . PHP_EOL;
        $print .= "            'page' => \$tabela->getPagina()," . PHP_EOL;
        $print .= "          'total' => \$tabela->calculaPaginacao(\$nLinhas['num'])," . PHP_EOL;
        $print .= "            'records' => \$nLinhas['num']" . PHP_EOL;

        $print .= '        );' . PHP_EOL;
        $print .= '        foreach ($result as $linhaBanco) {' . PHP_EOL;
        $print .= '            $row = array();' . PHP_EOL;
        $print .= '            $' . lcfirst($this->nome) . ' = $this->setDados($linhaBanco);' . PHP_EOL;
        $id = reset($this->campos);
        $print .= "            \$row['id'] = \$" . lcfirst($this->nome) . '->get' . lcfirst($id->getVariavel()) . '();' . PHP_EOL;
        $print .= "            \$row['cell'] = \$" . lcfirst($this->nome) . "->getArrayJson();" . PHP_EOL;
        $print .= '            $dados[] = $row;' . PHP_EOL;
        $print .= '       }' . PHP_EOL;
        $print .= "        \$resultado['rows'] = \$dados;" . PHP_EOL;
        $print .= '        return $resultado;' . PHP_EOL;
        $print .= '    }' . PHP_EOL;
        $print .= PHP_EOL;

        $print .= $this->getByID();

        $print .= '     /**' . PHP_EOL;
        $print .= '     * Método que retorna um array de objetos ' . $this->nome . PHP_EOL;
        $print .= '     * sendo determinado pelo parâmetro $condicao' . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     * @param String $condicao - Condição da consulta' . PHP_EOL;
        $print .= '     * @return Array de objetos ' . $this->nome . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '    public function getLista($condicao = false)' . PHP_EOL . '    {' . PHP_EOL;
        $print .= '        $dados = array();' . PHP_EOL;
        $print .= "        \$result = \$this->queryTable(  '" . $this->tabela->getNomeCompleto() . " ', " . PHP_EOL;
        $print .= $this->getColunas() . "'," . PHP_EOL;
        $print .= '            $condicao);' . PHP_EOL;
        $print .= '        foreach ($result as $linhaBanco) {' . PHP_EOL;
        $print .= '            $' . lcfirst($this->nome) . ' = $this->setDados($linhaBanco);' . PHP_EOL;
        $print .= '            $dados[] = $' . lcfirst($this->nome) . ';' . PHP_EOL;
        $print .= '       }' . PHP_EOL;
        $print .= '        return $dados;' . PHP_EOL;
        $print .= '    }' . PHP_EOL . PHP_EOL;

        $print .= $this->setDados();
        $print .= $this->inserirEmTransacao();
        return $print .= '}';
    }

    private function getColunas() {        
        if (empty($this->colunas)) {
            $campos = $this->tabela->getColunas();
            $campo = array_shift($campos);
            $print = "                                         '" . $campo->getNome() . ' as principal ';
            foreach ($campos as $campo) {
                $print .= ',' . PHP_EOL . "                                          " . $this->getColuna($campo);
            }
            $this->colunas = $print;
        }
        return $this->colunas;
    }

    private function getColuna(ColunaGerador $coluna){
        if($coluna->isGeo()){
           return 'ST_ASTEXT('.$coluna->getNome().') as '. $coluna->getNome();
        }
        return $coluna->getNome();
    }

    private function setDados(){
        $print  = '    /**' . PHP_EOL;
        $print .= '     * Método Private que retorna um objeto setado ' . $this->nome . PHP_EOL;
        $print .= '     * com objetivo de servir as funções getTabela, getLista e get' . ucfirst($this->nome) . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     * @param array $linha' . PHP_EOL;
        $print .= '     * @return objeto ' . $this->nome . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '    private function setDados($dados)' . PHP_EOL . '    {' . PHP_EOL;
        $print .= '        $' . lcfirst($this->nome) . ' = new ' . $this->nome . '();' . PHP_EOL;
        $campos = $this->campos;
        $campo = array_shift($campos);
        $print .= '        $' . lcfirst($this->nome) . "->set" . ucfirst($campo->getVariavel()) . "(\$dados['principal']);" . PHP_EOL;
        foreach ($campos as $campo) {
           $print .= '        $' . lcfirst($this->nome) . "->set" . ucfirst($campo->getVariavel()) . '(' . $this->getObjeto($campo). ');' . PHP_EOL;
        }
        $print .= '        return $' . lcfirst($this->nome) . ';' . PHP_EOL;
        $print .= '    }' . PHP_EOL;

        return $print;
    }

    private function getObjeto(ColunaGerador $campo){
        if($campo->isGeo()){
            return 'new ' . $campo->geometria() . "(\$dados['" . $campo . "'])";
        }
        return "\$dados['" . $campo . "']";
    }

    /**
     *
     * @return String código do método
     */
    private function inserirEmTransacao() {
        $print = PHP_EOL . '    /**' . PHP_EOL;
        $print .= '     * Método que insere um objeto do tipo ' . $this->nome . PHP_EOL;
        $print .= '     * na tabela do banco de dados' . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     * @param ' . $this->nome . ' Objeto data transfer' . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '    public function inserirEmTransacao(' . $this->nome .' $obj)' . PHP_EOL . '    {' . PHP_EOL;
        $print .= '        $this->DB()->begin();' . PHP_EOL;
        $print .= '        if ($this->save($obj)) {' . PHP_EOL;
        $print .= '            $sequencia = ' . "'" . $this->tabela->getSchema() . '.' .
                                                  $this->tabela->getNomeTabela() . '_id_' .
                                                  $this->tabela->getNomeTabela() . "_seq';" . PHP_EOL;
        $print .= '        $id = $this->DB()->lastInsertId($sequencia);' . PHP_EOL;
        $print .= '        $this->DB()->commit();' . PHP_EOL;
        $print .= '        return $id;' . PHP_EOL;
        $print .= '    } else {' . PHP_EOL;
        $print .= '        return false;' . PHP_EOL;
        $print .= '    }' . PHP_EOL;
        return $print .= '   }' . PHP_EOL;
    }
    
    private function getByID(){
        $print = '     /**' . PHP_EOL;
        $print .= '     * Método que retorna um objeto do tipo ' . $this->nome . PHP_EOL;
        $print .= '     * sendo determinado pelo identifcador do mesmo na tabela' . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     * @param integer $id - Identificador do dado' . PHP_EOL;
        $print .= '     * @return ' . $this->nome . ' - Objeto data transfer' . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '    public function getByID($id) {' . PHP_EOL;
        $print .= '        $' . lcfirst($this->nome) . ' = new ' . $this->nome . '();' . PHP_EOL;
        $print .= '        $consulta = $this->queryTable($' . lcfirst($this->nome) . '->getTable(),' . PHP_EOL;

        $print .= $this->getColunas() ."'," . PHP_EOL;
        $chaves = $this->tabela->getChavePrimaria();
        $print .= "                        '" . reset($chaves) . " ='. \$id" . ' );' . PHP_EOL;
        $print .= '        if ($consulta) {' . PHP_EOL;
        $print .= '            $' . lcfirst($this->nome) . ' = $this->setDados($consulta->fetch());' . PHP_EOL;

        $print .= '            return $' . lcfirst($this->nome) . ';' . PHP_EOL;
        $print .= '        } else {' . PHP_EOL;
        $print .= '             throw new EntradaDeDadosException();' . PHP_EOL;
        $print .= '        }' . PHP_EOL;
        $print .= '     }' . PHP_EOL;
        return $print;
    }

    private function arquivoEmBanco() {

    }

    private function arquivoEmDir() {
        $print = PHP_EOL;
        $print .= 'private function inserirArquivo(' . $this->nome . ' $obj, Foto $foto, $alterar = false) {' . PHP_EOL;
        $print .= '$nomeArq = $produto->geraNome();' . PHP_EOL;;
        $endFisico = ROOT . '../www/imagens/produtos/';
        $endLogico = '/imagens/produtos/';

        if (!$alterar) {
            $fotoProduto = new ArquivoUpload($_FILES['caminhoFoto']);
            $r = new Redimensionador($fotoProduto->getArquivo(), $endFisico . $nomeArq . '.jpg', 272, 272);
            $r2 = new Redimensionador($fotoProduto->getArquivo(), $endFisico . $nomeArq . '_mini.jpg', 100, 100);
            $foto->setCaminhoFoto($endLogico . $nomeArq . '.jpg');
            $foto->setIdProduto($produto->getIdProduto());
            return $r && $r2;
        } else {
            $end = ROOT . '../www' . $_POST['foto'];
            $miniEnd = str_replace('.jpg', '_mini.jpg', $end);

            $fotoProduto = new ArquivoUpload($_FILES['caminhoFotoSubstituir']);
            if ($fotoProduto->isOk()) {
                unlink($end);
                unlink($miniEnd);
                $r = new Redimensionador($fotoProduto->getArquivo(), $end, 272, 272);
                $r2 = new Redimensionador($fotoProduto->getArquivo(), $miniEnd, 100, 100);
                return $r && $r2;
            }
        }
        $print .= '         return true;' . PHP_EOl;
        $print .= '     }' . PHP_EOl;
        return $print;
    }
}
