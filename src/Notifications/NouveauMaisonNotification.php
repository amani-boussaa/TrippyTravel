<?php


namespace App\Notifications;






// On importe les classes nécessaires à l'envoi d'e-mail et à Twig
use Swift_Mailer;
use Swift_SmtpTransport;
use Swift_Message;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class NouveauMaisonNotification
{
    /**
     * Propriété contenant le module d'envoi de mail
     *
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * Propriété contenant l'environnement twig
     *
     * @var Environment
     */
    private $renderer;

    /**
     * Constructeur de classe
     * @param Swift_Mailer $mailer
     * @param Environment $renderer
     */
    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    /**
     * Méthode de notification (envoi de mail)
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function notify()
    {

        $transport = (new Swift_SmtpTransport('smtp.googlemail.com', 465, 'ssl'))
      ->setUsername('trippytravel9@gmail.com')
      ->setPassword('trippy2022');

       $this->mailer = new Swift_Mailer($transport);

       $body = 'Hello, <p> une maison a été  <span style="color:red;"> ajoutée</span>.</p>';

        // On construit le mail
        $message = (new Swift_Message('Consulter votre forum il y a une nouvelle maison !!'))
      ->setFrom(['trippytravel9@gmail.com' => 'trippy notifier'])
      ->setTo(['samar.belarbi@esprit.tn'])

      ->setBody($body)
      ->setContentType('text/html')
    ;
        // On envoie le mail
        $this->mailer->send($message);
    }
}