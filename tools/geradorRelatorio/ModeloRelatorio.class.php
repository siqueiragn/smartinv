<?php

/**
 * Classe responsável por gerar o modelo de dados.
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @package tools.geradorRelatorio
 * @version 1.0.0
 */
class ModeloRelatorio
{

    private $view;
    private $config;

    public function __construct(View $view, ConfiguracaoGerador $config)
    {
        $this->view = $view;
        $this->config = $config;
    }

    public function gerar()
    {

        $print = '<?php' . PHP_EOL;
        $print .= PHP_EOL;
        $print .= '/**' . PHP_EOL;
        $print .= ' * Classe de modelo referente ao relatório ' . ucfirst($this->view->getLabel()) . ' ' . PHP_EOL;
        $print .= ' *' . PHP_EOL;
        $print .= ' * @package app.model.relatorios.' . lcfirst($this->view->getModulo()) . PHP_EOL;
        $print .= ' * @author ' . $this->config->getAutor() . ' <' . $this->config->getEmailAutor() . '>' . PHP_EOL;
        $print .= ' * @version 1.0.0 - ' . date('d-m-Y') . '(Gerado automaticamente - GR - ' . VERSAO . ')' . PHP_EOL;
        $print .= ' */' . PHP_EOL;
        $print .= 'class ' . $this->view->getNomeCamelCase() . 'Model extends AbstractModel ' . PHP_EOL . '{';
        $print .= PHP_EOL . PHP_EOL;
        $print .= '    /**' . PHP_EOL;
        $print .= '    * Construtor da classe ' . $this->view->getNomeCamelCase() . 'Model esse metodo  ' . PHP_EOL;
        $print .= '    * instancia o Modelo padrão conectando o mesmo o banco de dados' . PHP_EOL;
        $print .= '    *' . PHP_EOL;
        $print .= '    */' . PHP_EOL;
        $print .= '    public function __construct()' . PHP_EOL . '    {' . PHP_EOL;

        $print .= "        parent::__construct('" . $this->config->getBanco() . "');" . PHP_EOL;

        $print .= '    }' . PHP_EOL;
        $print .= PHP_EOL;

        $print .= $this->getDados();

        return $print .= '}';
    }

    public function getDados()
    {
        $print = '    /**' . PHP_EOL;
        $print .= '     * Método que retorna um array com a view dos dados de ' . $this->view->getLabel() . PHP_EOL;
        $print .= '     *' . PHP_EOL;
        $print .= '     * @return Array - view de dados' . PHP_EOL;
        $print .= '     */' . PHP_EOL;
        $print .= '    public function getTabela(TabelaConsulta $view)' . PHP_EOL . '    {' . PHP_EOL;
        $print .= '        $dados = array();' . PHP_EOL;
        $colunas = $this->view->getColunas();
        $print .= "        \$nLinhasCon = \$this->queryTable('" . $this->view->getNomeCompleto() . "', 'count(" . reset($colunas) . ") as num');" . PHP_EOL;
        $print .= '        $nLinhas = $nLinhasCon->fetch();' . PHP_EOL;
        $print .= "        \$result = \$this->queryTable(  '" . $this->view->getNomeCompleto() . " ' . \$view->getcondicao(), " . PHP_EOL;

        $print .= $this->getColunas() . "'" . PHP_EOL;
        $print .= '                                       );' . PHP_EOL;
        $print .= '        $resultado = array(' . PHP_EOL;
        $print .= "            'page' => \$view->getPagina()," . PHP_EOL;
        $print .= "          'total' => \$view->calculaPaginacao(\$nLinhas['num'])," . PHP_EOL;
        $print .= "            'records' => \$nLinhas['num']" . PHP_EOL;

        $print .= '        );' . PHP_EOL;
        $print .= '        foreach ($result as $linhaBanco) {' . PHP_EOL;
        $print .= '            $linha = array();' . PHP_EOL;
       
        $print .= "            \$linha['id'] = \$linhaBanco['principal'];" . PHP_EOL;
        $print .= "            \$linha['cell'] = " . $this->montaArray() . ';' . PHP_EOL;
        $print .= '            $dados[] = $linha;' . PHP_EOL;
        $print .= '       }' . PHP_EOL;
        $print .= "        \$resultado['rows'] = \$dados;" . PHP_EOL;
        $print .= '        return $resultado;' . PHP_EOL;
        $print .= '    }' . PHP_EOL;
        $print .= PHP_EOL;
        return $print;
    }

    private function getColunas()
    {
        $print = '';
        if (!empty($this->view->getColunas())) {
            $campos = $this->view->getColunas();
            $campo = array_shift($campos);
            $print .= "                                         '" . $campo->getNome() . ' as principal ';
            foreach ($campos as $campo) {
                $print .= ',' . PHP_EOL . "                                          " . $campo;
            }
        }
        return $print;
    }

    private function montaArray()
    {
        $print = 'array(';
        $colunas = $this->view->getColunas();
        $id = array_shift($colunas);
        $print .= "\$linhaBanco['" . $id . "'], ";
        foreach ($colunas as $campo) {
            $print .= "\$linhaBanco['" . $campo . "'], ";
        }
        $ret = rtrim($print, ', ');
        return $ret . ')';
    }

}
