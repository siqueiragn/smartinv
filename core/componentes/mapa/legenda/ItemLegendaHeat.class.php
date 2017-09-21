<?php

/*
 * Copyright .
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Description of LegendaHeat
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
class ItemLegendaHeat implements \JsonSerializable
{

    private $nome;
    private $minimo;
    private $maximo;
    private $cor;
    
    /**
     * 
     * @param type $minimo
     * @param type $maximo
     * @param type $cor
     */
    public function __construct($minimo, $maximo, $cor)
    {
        $this->minimo = $minimo;
        $this->maximo = $maximo;
        $this->cor = $cor;
        $this->nome = $minimo . ' - ' . $maximo; 
    }

    /**
     * Método que retorna o valor da variável minimo
     *
     * @return String - Valor da variável minimo
     */
    public function getMinimo()
    {
        return $this->minimo;
    }

    /**
     * Método que seta o valor da variável minimo
     *
     * @param String $minimo - Valor da variável minimo
     */
    public function setMinimo($minimo)
    {
        $this->minimo = $minimo;
        return $this;
    }

    /**
     * Método que retorna o valor da variável maximo
     *
     * @return String - Valor da variável maximo
     */
    public function getMaximo()
    {
        return $this->maximo;
    }

    /**
     * Método que seta o valor da variável maximo
     *
     * @param String $maximo - Valor da variável maximo
     */
    public function setMaximo($maximo)
    {
        $maximo = trim($maximo);
        $this->maximo = $maximo;
        return true;
    }

    /**
     * Método que retorna o valor da variável cor
     *
     * @return String - Valor da variável cor
     */
    public function getCor()
    {
        return $this->cor;
    }

    /**
     * Método que seta o valor da variável cor
     *
     * @param String $cor - Valor da variável cor
     */
    public function setCor($cor)
    {
        $cor = trim($cor);
        $this->cor = $cor;
        return true;
    }

    /**
     * Método que retorna o valor da variável nome
     *
     * @return String - Valor da variável nome
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Método que seta o valor da variável nome
     *
     * @param String $nome - Valor da variável nome
     */
    public function setNome($nome)
    {
        $nome = trim($nome);
        $this->nome = $nome;
        return $this;
    }
    
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

}
