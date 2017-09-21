<?php

/**
 * Classe com métodos 
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package util
 */
class DateUtil
{

    public static function monthYear($input, $format = 'Y-m-d')
    {
        $date = DateTime::createFromFormat($format, $input);
        return $date->format('m/Y');
    }
    
     public static function preparaData($data, $obrigatorio = true) {
        if (empty($data) && !$obrigatorio) {
            return '';
        }

        $dataTeste = explode('-', $data);
        if (sizeof($dataTeste) == 3 && $dataTeste[0] > 1850) {
            $ano = trim($dataTeste[0]);
            $mes = trim($dataTeste[1]);
            $dia = trim($dataTeste[2]);
            return $ano . '-' . $mes . '-' . $dia;
        }

        $data = str_replace('.', '/', $data);
        $data = str_replace('-', '/', $data);

        $data = explode('/', $data);
        if (isset($data[2])) {
            if ($data[2] < 1000) {
                if ($data[2] < 70) {
                    $data[2] += 2000;
                } else {
                    $data[2] += 1900;
                }
            }
        } else {
            return false;
        }
        $ano = trim($data[2]);
        $mes = trim($data[1]);
        $dia = trim($data[0]);
        $data = $ano . '-' . $mes . '-' . $dia;
        return $data;
    }

}
