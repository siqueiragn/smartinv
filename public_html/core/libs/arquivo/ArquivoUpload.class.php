<?php

/**
 * Classe responsável por manipular os arquivos enviados via upload
 * 
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0.0 - 22/05/2011
 */
class ArquivoUpload implements \core\model\io\ObjetoInsercao
{

    private $endServidor;
    private $erro;
    private $tamanho;
    private $tipo;
    private $nome;
    private $oid;
    private $id = false;
    private $extensao = false;

    public function __construct($arquivo)
    {
        if (is_file($arquivo['tmp_name'])) {
            $this->endServidor = $arquivo['tmp_name'];
            $this->erro = $arquivo['error'];
            $this->tamanho = $arquivo['size'];
            $this->tipo = $arquivo['type'];
            $this->nome = $arquivo['name'];
        } else {
            $this->erro = 4;
        }
    }

    /**
     * Verifica se o arquivo foi enviado corretamente
     * 
     * @return boolean 
     */
    public function isValid()
    {
        if ($this->erro == UPLOAD_ERR_OK) {
            return true;
        } else {
            return false;
        }
    }

    public function getErrorMessage()
    {
        if ($this->erro == UPLOAD_ERR_OK) {
            return 'Não houve erro ao carregar arquivo';
        } else if ($this->erro == UPLOAD_ERR_NO_FILE) {
            return 'Você deve enviar ao menos um arquivo';
        } else {
            #FIXME criar outras mensagens de erro
            return 'Erro ao carregar arquivo';
        }
    }


    /**
     * 
     * @return type
     */
    public function getArquivo()
    {
        return $this->endServidor;
    }

    /**
     * Método que retorna o tamanho do arquivo.
     *
     * @return integer - Tamanho do arquivo
     */
    public function getTamanho()
    {
        return $this->tamanho;
    }

    /**
     * Método que retorna o mime/type do arquivo
     * 
     * @return String Mime do arquivo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getOid()
    {
        return $this->oid;
    }

    public function setOid($oid)
    {
        $this->oid = $oid;
    }

    /**
     * Método que move o arquivo enviado para um determinado diretório.
     * 
     * @param type $diretorio - diretorio para onde será movido o arquivo
     * @param type $nome - nome do arquivo
     */
    public function mover($diretorio, $nome = false)
    {
        $nome = $this->slugNome();
        return move_uploaded_file($this->endServidor, $diretorio . '/' . $nome);
    }

    public function __toString()
    {
        return $this->nome . ' ' . $this->tamanho;
    }

    public function codigoInsercao()
    {
        return $this->oid;
    }
    
    public function nomePorValor($nome = false){
        $nomeTmp = $nome == false ? $this->nome : $nome;
        $sluger = new Slug\Slugifier();
        $sluger->setLowercase(true);
        $sluger->setTransliterate(true);            
        $nomeFinal = $sluger->slugify($nomeTmp);
        
        return $nomeFinal . '.' . $this->getExtensao();
    }
    
        /**
     * Método que gera um nome para o arquivo, caso o mesmo possua um id retorna 
     * o nome do arquivo com um id, caso contrário gera u nome único para salvar 
     * em uma pasta
     * 
     * @return String nomeUnico.ext
     */
    public function nomePorId()
    {
        if ($this->id === false) {
            $nome = md5(uniqid());
        } else {
            $nome = $this->id;
        }
        return $nome .  '.' . $this->getExtensao();
    }

    
    public function getExtensao(){
        if(!$this->extensao){
            $pieces = explode('.', $this->nome);
            $this->extensao = end($pieces);
        }
        return $this->extensao;
    }
    
    

}
