<?php

/**
 * Classe responsável por redimencionar uma imagem, sem alterar proporção para o 
 * tamanho especificado, aceita imagens dos tipos  JPG,GIF,PNG, setando a sua 
 * variavel $status caso seja passado uma arquivo inválido.
 *
 * @author Marcio Bigolin
 * @package controlador.libs.imagens
 * @version 1.0.3 - 04/06/2008
 */
class Redimensionador {

    private $status = true;

    /**
     * Construtor da classe recebe os parâmetros para redimencionar a Imagem
     *
     * @param String $endAtual - Endereço do arquivo a ser redimencionado.
     * @param String $endNovo - Endereço onde será salvo o arquivo novo.
     * @param int $largura - Largura máxima que a imagem poderá obter - Se for 0 a largura será ignorada.
     * @param int $altura - Altura máxima que a imagem poderá obter - Se for 0 a altura será ignorada.
     */
    public function __construct($endAtual, $endNovo, $largura, $altura = 0) {
        $this->status = true;
        if ($altura == 0) {
            if (!$this->redimencionarLargura($endAtual, $endNovo, $largura)) {
                $this->status = false;
            }
        } else if ($largura == 0) {
            if (!$this->redimencionarAltura($endAtual, $endNovo, $altura)) {
                $this->status = false;
            }
        } else {
            //list($Ilargura, $Ialtura) = getimagesize($endAtual);
            //echo $Ilargura." ".$Ialtura;
            if (!$this->redimencionarLargura($endAtual, $endNovo, $largura)) {
                $this->status = false;
            }
            if (!$this->redimencionarAltura($endNovo, $endNovo, $altura)) {
                $this->status = false;
            }
        }
    }

    /**
     * Método que realiza o redimencionamento
     *
     * @param String $arquivo - Endereço do arquivo a ser redimencionado.
     * @param String $arquivoNovo - Endereço onde será salvo o arquivo novo.
     * @param int $max - dimensão máxima que pode atingir imagem
     * @param int $sel - se 1 o $max redimensiona pela largura senão redireciona 
     *                      pela altura
     * @return Bool retorna false se a imagem não for de um tipo aceito
     */
    public function redimencionarAltura($arquivo, $arquivoNovo, $max) {
        list($largura, $altura, $tipo) = getimagesize($arquivo);
        $percent = $this->calculoPorcentagem($max, $altura);
        $newwidth = $largura * $percent;
        $newheight = $altura * $percent;
        // Load
        $thumb = imagecreatetruecolor($newwidth, $newheight);        
        $source = self::getTipoArquivo($tipo, $arquivo);

        // Resize
        if (!imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $largura, $altura)) {
            return false;
        }
        // Output
        imagejpeg($thumb, $arquivoNovo, 99);
        return true;
    }

    /**
     * 
     * @param type $arquivo
     * @param type $arquivoNovo
     * @param type $max
     * @return boolean
     */
    public function redimencionarLargura($arquivo, $arquivoNovo, $max) {
        list($largura, $altura, $tipo) = getimagesize($arquivo);
        $percent = $this->calculoPorcentagem($max, $largura);
        $newwidth = $largura * $percent;
        $newheight = $altura * $percent;
        // Load
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = self::getTipoArquivo($tipo, $arquivo);
        // Resize
        if (!imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $largura, $altura)) {
            return false;
        }
        // Output
        imagejpeg($thumb, $arquivoNovo, 100);
        return true;
    }
    
    
     /**
     * 
     * @param type $end - Endereço do arquivo
     * @param type $largura - Largura nova
     * @param type $altura - Altura nova
     */
    public static function redimensionarTransparente($end, $largura, $altura) {
        list($larguraIni, $alturaIni, $tipo) = getimagesize($end);
        $thumb = imagecreatetruecolor($largura, $altura);
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
        $source = self::getTipoArquivo($tipo, $end);
        imagealphablending($source, true);
        imagesavealpha($source, true);
        // Resize
        if (!imagecopyresampled($thumb, $source, 0, 0, 0, 0, $largura, $altura, $larguraIni, $alturaIni)) {
            return false;
        }
        return $thumb;
    }

    /**
     * 
     * @param type $end - Endereço do arquivo
     * @param type $largura - Largura nova
     * @param type $altura - Altura nova
     */
    public static function redimensionarTransparente8($end, $largura, $altura) {
        list($larguraIni, $alturaIni, $tipo) = getimagesize($end);
        $thumb = imagecreatetruecolor($largura, $altura);
       
        $source = self::getTipoArquivo($tipo, $end);
        // Resize
        if (!imagecopyresampled($thumb, $source, 0, 0, 0, 0, $largura, $altura, $larguraIni, $alturaIni)) {
            return false;
        }
        return $thumb;
    }

    /**
     * 
     * @param type $end - Endereço do arquivo
     * @param type $largura - Largura nova
     * @param type $altura - Altura nova
     */
    public static function redimensionar($end, $largura, $altura){
        list($larguraIni, $alturaIni, $tipo) = getimagesize($end);
        $thumb = imagecreatetruecolor($largura, $altura);
        $source = self::getTipoArquivo($tipo, $end);
        // Resize
        if (!imagecopyresampled($thumb, $source, 0, 0, 0, 0, $largura, $altura, $larguraIni, $alturaIni)) {
            return false;
        }
        return $thumb;
    }
    
    private static function getTipoArquivo($tipo, $arquivo){
        switch ($tipo) {
            case 1:
                return imagecreatefromgif($arquivo);
            case 2:
                return imagecreatefromjpeg($arquivo);
            case 3:
                return imagecreatefrompng($arquivo);
            default:
                return false;
        }
    }

    /**
     * Método que calcula o valor em porcentagem de quanto tem que reduzir ou 
     * aumentar da imagem.
     *
     * @param int $maximo - Valor máximo que poderá assumir
     * @param int $atual - Valor atual do lado da imagem
     * @return int Valor em porcentam da redução ou ampliação
     */
    private function calculoPorcentagem($maximo, $atual) {
        if ($atual == 0) {
            $this->status = false;
            return false;
        }
        return ((($maximo * 100) / $atual) / 100);
    }

    /**
     * Método que retorna o status do objeto de redimencionamento, se ele estiver em false ou
     * porque recebeu uma imagem ou arquivo inválido.
     *
     * @return bool Status do objeto
     */
    public function getStatus() {
        return $this->status;
    }

}
