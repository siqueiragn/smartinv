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
class LegendaHeat extends Legenda
{

    private $id;
    private $itens;
    private $gid;
    private $vetorDados;
    private $paleta;
    private $pattern = false;
    private $stroke = false;

    public function __construct($vetorDados, $gid = 'codGeo')
    {
        $this->paleta = new Paleta();
        $this->vetorDados = $vetorDados;
        $this->id = self::$i++;
        $this->gid = $gid;
    }

    public function getVetorDados()
    {
        
    }

    public function addItem(ItemLegendaHeat $item)
    {
        $this->itens[] = $item;
    }

    public function getVariavel()
    {
        return 'legenda' . $this->id;
    }

    /**
     * Método que permite adicionar algum pattern pré-definido na camada
     */
    public function doPattern()
    {
        $this->pattern = true;
        return $this;
    }

    public function setStroke($stroke = true)
    {
        $this->stroke = $stroke;
    }


    private function getFillColor()
    {
        if ($this->pattern) {
            return 'makeAutoPattern(valor, legenda' . $this->id . ');';
        }
        return 'getCor(valor, legenda' . $this->id . ');';
    }

    public function getFormatter()
    {
        return 'function(feature, resolution){' . PHP_EOL
                . ' var data = feature.getProperties();
            var valor = ' . $this->vetorDados . '[data.' . $this->gid . '];
            var cor = ' . $this->getFillColor() . ';            
            armazenaEstatistica("' . $this->vetorDados . '", cor);         
            return [new ol.style.Style({
                fill: new ol.style.Fill({
                    color: cor
                    })
                    ' . $this->makeStroke() . '}
            )];'
                . '}' . PHP_EOL;
    }

    public function geraQuartil($min, $max)
    {
        $steps = ($max - $min) / 4;
        $atual = $min;
        $j = 0;
        for ($i = 0; $i < 4; $i ++) {
            $atual = $min + $steps;
            $this->addItem(new ItemLegendaHeat($min, $atual, '#' . $this->paleta->getCor($j)));
            $min = $atual;
            $j += 2;
        }
    }

    public function setCor($cor)
    {
        $this->paleta = new Paleta($cor);
    }

    public function __toString()
    {
        return 'var legenda' . $this->id . ' = ' . json_encode($this->itens)
                . ';' . PHP_EOL;
    }
    
    private function makeStroke()
    {
        if (is_string($this->stroke)) {
            $stroke = $this->stroke;
        }else if ($this->stroke) {
            $stroke =  '
                stroke: new ol.style.Stroke({
                                width: 3, color: "rgba(255, 255, 255, 1)",
                                lineDash: [.1, 6] 
                })';
        } else {
            return '';
        }
        return ',' . $stroke;
    }


}
