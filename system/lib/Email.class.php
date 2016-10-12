<?php

/**
 * Classe de envio de e-mail
 * */
class Email {

    public $mailer;        
  
    
    function __construct( $configurationData ) {

        $this->mailer = new PHPMailer();

        $this->mailer->CharSet = "UTF-8";

        $this->mailer->isSMTP();
        $this->mailer->Host     = $configurationData['host'];
        $this->mailer->Port     = $configurationData['port'];
        $this->mailer->SMTPAuth = $configurationData['auth'];

        if ($configurationData['auth']) {
            
            $this->mailer->Username = $configurationData['user'];
            $this->mailer->Password = $configurationData['pass'];
            
        }

        if ($configurationData['secure'] && in_array($configurationData['secure'], array('ssl', 'tls'))) {
            
            $this->mailer->SMTPSecure = $configurationData['secure'];
        }

        //Definindo o sender
        if (isset($configurationData['from']) && isset($configurationData['from_name'])) {
            
            $this->mailer->senderName  = $configurationData['from_name'];
            $this->mailer->senderEmail = $configurationData['from'];
            
        } else {
            
            throw new Exception('Undefined e-mail sender variables');
        }
        
        $this->mailer->setFrom( $this->mailer->senderEmail, $this->mailer->senderName );
    }

    
    function sendEmail($to, $subject, $htmlContents, $textContents = null, $attachments = null) {

        $this->mailer->Subject = $subject;
        
        //Set who the message is to be sent from
        $this->mailer->setFrom($this->mailer->senderEmail, $this->mailer->senderName);

        foreach ($to as $person) {

            $this->mailer->addAddress($person['email'], $person['name']);
        }

        if ($htmlContents) {

            $this->mailer->msgHTML($htmlContents);

            if ($textContents) {

                $this->mailer->AltBody = $textContents;
            }
            
        } elseif ($textContents) {

            $this->mailer->Body = $textContents;
            
        } else {

            throw new Exception('Conteúdo não definido para o email ' . $subject);
        }

        if ($attachments) {

            foreach ($attachments as $attachment) {

                $this->mailer->addAttachment($attachment['path']);
            }
        }

        try {
            
            $this->mailer->send();
            
        } catch (Exception $e) {

            throw new Exception('Erro ao enviar e-mail: ' . $e->getMessage());
        }
    }
}