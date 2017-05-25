<?php

/**
 * Description of TemplateGerador
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0.0
 */
class TemplateGerador extends ArquivoGerador
{

    private $inserts = "{*Inserts para sys.traducao \n\n";
    private $labelsFor = true;

    /**
     * 
     * @return string código para salvar no arquivo
     */
    public function gerar()
    {
        $print = '{*Gerado automaticamente com GC - ' . VERSAO . '*}' . PHP_EOL;
        $print .= '<fieldset' . $this->classFieldset() . '>' . PHP_EOL;
        if ($this->config->isInternacionalizacao()) {
            $print .= $this->gerarComInternacionalizacao();
        } else {
            $print .= $this->gerarSemInternacionalizacao();
        }
        $print .= '</fieldset>' . PHP_EOL . PHP_EOL;
        return $print;
    }

    private function classFieldset()
    {
        if ($this->labelsFor) {
            return ' class="formPadrao"';
        }
    }

    private function geraInput(ColunaGerador $campo, $classe)
    {
        $input = '<input';
        $input .= $this->getTypeInput($campo->getTipo());
        $input .=' id="' . $campo->getVariavel() . '" name="' . $campo->getVariavel() . '"';
        if ($campo->getTipo() == 'bool' || $campo->getTipo() == 'boolean') {
            $input .= ' value="true"';
            $input.=' {if $' . lcfirst($classe) . '->get' . ucfirst($campo->getVariavel()) . '()} checked="checked"{/if}';
        } else {
            $input .= ' value="{$' . lcfirst($classe) . '->get' . ucfirst($campo->getVariavel()) . '()}"';
        }
        $input .= $this->getValidacao($campo);
        $input .= $this->getExtras($campo);
        $input .= ' />';
        return $input;
    }

    private function geraSelect(ColunaGerador $campo, $classe)
    {

        $lista = str_replace('id', '', $campo->getVariavel());
        $select = '<select ';
        $select .='id="' . $campo->getVariavel() . '" name="' . $campo->getVariavel() . '" class="form-control">' . PHP_EOL;
        $select .= '    		{html_options options=$lista' . ucfirst($lista) . ' selected=$' . lcfirst($classe) . '->get' . ucfirst($campo->getVariavel()) . '()}' . PHP_EOL;
        $select .= '             </select>' . PHP_EOL;

        return $select;
    }

    private function getInserts()
    {
        return $this->inserts;
    }

    private function geraInsertTraducao(ColunaGerador $campo)
    {
        $this->inserts .= 'INSERT INTO sys.traducao (pt_br,en) VALUES ("' . $campo . '","' . $campo . '");' . PHP_EOL;
    }

    private function geraInsertTraducaoDefault()
    {
        $this->inserts .= 'INSERT INTO sys.traducao (pt_br,en) VALUES ("Novo ' . $this->tabela->getLabel() . '","New ' . $this->tabela->getLabel() . '");' . PHP_EOL;
        $this->inserts .= 'INSERT INTO sys.traducao (pt_br,en) VALUES ("Editar ' . $this->tabela->getLabel() . '","Edit ' . $this->tabela->getLabel() . '");' . PHP_EOL;
    }

    private function getValidacao(ColunaGerador $campo)
    {
        $tipo = $campo->getTipo();
        $ret = ' class="';
        if ($tipo == 'int4' || $tipo == 'integer') {
            $ret .='validaInteiro';
        } else if ($tipo == 'timestamp') {
            $ret .='validaDataHora';
        } else if ($tipo == 'date') {
            $ret .='validaData';
        } else if ($tipo == 'double precision') {
            $ret .='validaFloat';
        }
        if ($this->labelsFor) {
            $ret .= ' form-control';
        }

        return $ret . '"';
    }

    private function getExtras(ColunaGerador $campo)
    {
        $ret = ' ';
        if ($campo->isNotNull()) {
            $ret .= 'required ';
        }
        return $ret;
    }

    private function getTypeInput($tipo)
    {

        if ($tipo == 'boolean' || $tipo == 'bool') {
            return ' type="checkbox"';
        } else if ($tipo == 'hidden' || $tipo == 'serial') {
            return ' type="hidden"';
        } else if ($tipo == 'oid' || $tipo == 'polygond' || $tipo == 'geometry') {
            return ' type="file"';
        } else {
            return ' type="text"';
        }
    }

    private function gerarSemInternacionalizacao()
    {
        $print = '     <legend>' . $this->tabela->getLabel() . '</legend>' . PHP_EOL;
        $this->geraInsertTraducaoDefault();
        foreach ($this->campos as $campo) {
            if ($campo->ignorarEmTpl()) {
                continue;
            }
            if ($campo->isChavePrimaria() && !$this->tabela->isChaveComposta()) {
                $campo->setTipo('serial');
                $print .= '             ' . $this->geraInput($campo, $this->nome) . PHP_EOL;
                continue;
            }
            if ($this->labelsFor) {
                $print .= $this->labelFor($campo);
            } else {
                $print .= '         <label>' . PHP_EOL;
                $print .= '             ' . ucfirst($campo->getLabel()) . PHP_EOL;
                $print .= $this->geraFormaEntrada($campo);
                $print .= '         </label>' . PHP_EOL;
            }
        }
        return $print;
    }

    /**
     * Gera o label em formato separado com for para utilizar junto ao bootstrap
     * 
     * @param ColunaGerador $campo
     * @return string
     */
    private function labelFor(ColunaGerador $campo)
    {
        $print = '         <div class="form-group">' . PHP_EOL;
        $print .= '              <label class="control-label col-sm-2" for="' . $campo->getVariavel() . '">' . ucfirst($campo->getLabel()) . '</label>' . PHP_EOL;
        $print .= '              <div class="col-sm-8">' . PHP_EOL;
        $print .= '    ' . $this->geraFormaEntrada($campo);
        $print .= '              </div>' . PHP_EOL;
        $print .= '         </div>' . PHP_EOL;
        return $print;
    }

    private function gerarComInternacionalizacao()
    {
        $print = '     <legend>{$_IDIOMA["' . $this->tabela->getLabel() . '"]}</legend>' . PHP_EOL;
        $this->geraInsertTraducaoDefault();
        foreach ($this->campos as $campo) {
            if ($campo->ignorarEmTpl()) {
                continue;
            }
            if ($campo->isChavePrimaria()) {
                $print .= '             ' . $this->geraInput($campo, $this->tabela->getNomeTabela()) . PHP_EOL;
                continue;
            }
            $print .= '         <label>' . PHP_EOL;

            $this->geraInsertTraducao($campo);

            $print .= '             {$_IDIOMA["' . ucfirst($campo->getLabel()) . '"]}' . PHP_EOL;
            $print .=$this->geraFormaEntrada($campo);
            $print .= '         </label>' . PHP_EOL;
        }
        $print .= '</fieldset>' . PHP_EOL . PHP_EOL;
        $print .= $this->getInserts() . PHP_EOL . '*}' . PHP_EOL;
        echo $print;
        return $print;
    }

    private function geraTextArea($campo, $classe)
    {
        $textarea = '<textarea';

        $textarea .=' id="' . $campo->getVariavel() . '" name="' . $campo->getVariavel() . '"';
        $textarea .= $this->getValidacao($campo);
        $textarea .= $this->getExtras($campo);
        $textarea .= '>{$' . lcfirst($classe) . '->get' . ucfirst($campo->getVariavel()) . '()}</textarea>';
        return $textarea;
    }

    private function isTextarea(CampoGerador $campo)
    {
        if (strpos($campo->getNome(), 'descricao') !== false) {
            return true;
        }
        return false;
    }

    /**
     * Método que determina se será gerado um campo do tipo select ou input
     * 
     * @param CampoGerador $campo
     * @return String Código Fonte gerado
     */
    private function geraFormaEntrada(CampoGerador $campo)
    {
        if ($campo->isChaveEstrangeira()) {
            return '             ' . $this->geraSelect($campo, $this->nome) . PHP_EOL;
        } else if ($this->isTextarea($campo)) {
            return '             ' . $this->geraTextArea($campo, $this->nome) . PHP_EOL;
        } else {
            return '             ' . $this->geraInput($campo, $this->nome) . PHP_EOL;
        }
    }

}
