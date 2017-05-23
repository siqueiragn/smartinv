<?php

/**
 * Classe que permite obter coordenadas nas mais diversas projeções fazendo uma consulta 
 * ao banco de dados.
 * 
 * Esta classe foi remodelada no dia 02/02/2015 para suportar o postigis 2.0 dúvidas visualizar
 * a issue #49 <https://gitlab.com/isam/sia/issues/49>
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 2.0.0 
 */
class Coordenadas {

    private $modelo;
    private $condicao;
    private $tabela;
    private $utm;
    private $latitudeDecimal;
    private $latitudeUtm;
    private $latitudeGrau;
    private $longitudeDecimal;
    private $longitudeUtm;
    private $longitudeGrau;

    /**
     * Construtor da classe o parametro modelo (opcional) permite que o objeto
     * se conecte ao banco e faça a consultas para converter as coordendas de forma
     * diferente.
     *
     * @param Modelo $modelo
     */
    public function Coordenadas(Modelo $modelo, $tabela, $condicao) {
        $this->modelo = $modelo;
        $this->tabela = $tabela;
        $this->condicao = $condicao;
        $this->latitudeGrau = false;
        $this->latitudeDecimal = false;
        $this->latitudeUtm = false;
        $this->longitudeGrau = false;
        $this->longitudeDecimal = false;
        $this->longitudeUtm = false;
    }

    public function setCoordenadas() {
         $consulta = $this->modelo->queryTable(
                        $this->tabela,
                        "ST_AsText(ST_Transform(coordenadas,4618)) as decimal,
                 ST_AsText(coordenadas) as utm,
                 DD2DMS(ST_x(ST_GeomFromText(
                        ST_AsText(ST_Transform(coordenadas,4618)))), '°','''','\"'
                       ) as Longitude,
                 DD2DMS(ST_y(ST_GeomFromText(
                        ST_AsText(ST_Transform(coordenadas,4618)))), '°','''','\"'
                       ) as Latitude",
                        $this->condicao);

        $coordenadas = $this->modelo->resultadoAssoc($consulta);
        $cor = str_replace('POINT(', '', $coordenadas['decimal']);
        $cor = str_replace(')', '', $cor);
        if($cor == ''){
            $msg = ' [Não cadastrado]';
            $this->longitudeDecimal = $msg;
            $this->latitudeDecimal = $msg;
            $this->latitudeUtm = $msg;
            $this->longitudeUtm = $msg;
            $this->latitudeGrau = $msg;
            $this->longitudeGrau = $msg;
            return;
        }
        list($this->longitudeDecimal, $this->latitudeDecimal) = explode(' ', $cor);
        $cor = str_replace('POINT(', '', $coordenadas['utm']);
        $cor = str_replace(')', '', $cor);
        list($this->latitudeUtm, $this->longitudeUtm) = explode(' ', $cor);
        $this->latitudeGrau = $coordenadas['latitude'];
        $this->longitudeGrau = $coordenadas['longitude'];

    }

    public function getLatitudeDecimal() {
        if ($this->latitudeDecimal === false) {
            $this->setCoordenadas();
            return $this->latitudeDecimal;
        } else {
            return $this->latitudeDecimal;
        }
    }

    public function getLongitudeDecimal() {
        if ($this->longitudeDecimal === false) {
            $this->setCoordenadas();
            return $this->longitudeDecimal;
        } else {
            return $this->longitudeDecimal;
        }
    }

    public function getLatitudeUtm() {
        if ($this->latitudeUtm === false) {
            $this->setCoordenadas();
            return $this->latitudeUtm;
        } else {
            return $this->latitudeUtm;
        }
    }

    public function getLongitudeUtm() {
        if ($this->longitudeUtm === false) {
            $this->setCoordenadas();
            return $this->longitudeUtm;
        } else {
            return $this->longitudeUtm;
        }
    }

    public function getLatitudeGrau() {
        if ($this->latitudeGrau === false) {
            $this->setCoordenadas();
            return $this->latitudeGrau;
        } else {
            return $this->latitudeGrau;
        }
    }

    public function getLongitudeGrau() {
        if ($this->longitudeGrau === false) {
            $this->setCoordenadas();
            return $this->longitudeGrau;
        } else {
            return $this->longitudeGrau;
        }
    }

}
