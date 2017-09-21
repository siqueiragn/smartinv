<?php

/**
 * A implementação da classe AES é baseada na documentação oficial disponibilizada em 
 * http://php.net/manual/pt_BR/function.mcrypt-encrypt.php
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 */
class Aes
{

    private $key;

    public function __construct($key = LOGIN_CHAVE)
    {
        $this->key = pack('H*', md5($key));
    }
    
    private function getIV(){
        return mcrypt_create_iv($this->getIVSize(), MCRYPT_RAND);
    }
    
    private function getIVSize(){
        return mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    }

    /**
     * 
     * @param type $valor
     * @return type
     */
    public function crypt($valor)
    {
        $iv = $this->getIV();
        # creates a cipher text compatible with AES (Rijndael block size = 128)
        # to keep the text confidential 
        # only suitable for encoded input that never ends with value 00h
        # (because of default zero padding)
        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->key, $valor, MCRYPT_MODE_CBC, $iv);

        # prepend the IV for it to be available for decryption
        $ciphertext = $iv . $ciphertext;

        # encode the resulting cipher text so it can be represented by a string
        return base64_encode($ciphertext);
    }

    public function decrypt($cript)
    {
        $iv_size = $this->getIVSize();
        $ciphertext_dec = base64_decode($cript);

        # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
        $iv_dec = substr($ciphertext_dec, 0, $iv_size);

        # retrieves the cipher text (everything except the $iv_size in the front)
        $ciphertext_dec = substr($ciphertext_dec, $iv_size);

        # may remove 00h valued characters from end of plain text
        return mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
    }

}
