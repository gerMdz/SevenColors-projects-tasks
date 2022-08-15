<?php

namespace App\Service\Mailer;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SendMail
{
    private MailerInterface $mailer;

    /**
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(array $data)
    {
        $email = (new TemplatedEmail())
//            ->from('hello@example.com')
            ->to($data['to'])
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($data['subject'])
            ->text($data['message'])
//            ->html($data['content'])

            ->htmlTemplate('mail/security/verifyMail.html.twig')

            // pass variables (name => value) to the template
            ->context(
                $data
            );

        $this->mailer->send($email);

        // ...
        return true;

    }
}