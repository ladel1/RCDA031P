<?php 

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService{


    public function __construct(private MailerInterface $mailer) { }

    public function sendEmail(
        $object
    ){

        $mail = (new Email())
            ->to("contact@exemple.fr")                        
            ->from($object->getEmail())
            ->subject($object->getSujet())
            ->html("<p>". $object->getContenu() ."</p>");

        $this->mailer->send($mail);

    }

}