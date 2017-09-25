<?php

/**
 * Classe com métodos 
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package util
 */
class MailUtil
{

    /**
     * 
     * @param type $from
     * @param type $dest
     * @param type $title
     * @param type $message
     * @return boolean
     */
    public static function sendMail($from, $dest, $title, $message)
    {  

        $mail = new PHPMailer();
        $mail->SetLanguage('br', CORE . 'vendor/phpmailer/phpmailer/language');
        $mail->IsSMTP();

        $mail->SMTPSecure = "tls";
        $mail->CharSet = 'UTF-8';
        $mail->Host = MAIL_SERVER;
        $mail->Port = MAIL_PORT;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USER;
        $mail->Password = MAIL_PASS;

        $mail->From = $from;
        $mail->FromName = $from;
        $eMails = is_array($dest)? $dest : explode(',',$dest);
        foreach($eMails as $destinatario){
            $mail->AddAddress($destinatario);
        }
        $mail->IsHTML(true);
        $mail->Subject = $title;
        $mail->Body = nl2br($message);

        if (!$mail->Send()) {
            #TODO criar e lançar exessão
            echo "Erro: " . $mail->ErrorInfo;
        } else {
            return true;
        }
    }
    
    public static function debugMail($message){
        
    }

}
