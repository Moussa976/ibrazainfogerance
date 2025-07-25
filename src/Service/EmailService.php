<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class EmailService
{
    private MailerInterface $mailer;
    private Environment $twig;
    private string $adminEmail;
    private string $logoPath;

    public function __construct(
        MailerInterface $mailer,
        Environment $twig,
        string $logoPath
    ) {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->adminEmail = 'contact@ibrazainfogerance.yt';//'';
        $this->logoPath = $logoPath;
    }

    public function envoyerContact(string $name, string $email, string $phone, string $subject, string $message): void
    {
        // Nettoyage simple (évite injections dans les mails)
        $name = strip_tags($name);
        $email = strip_tags($email);
        $phone = strip_tags($phone);
        $subject = strip_tags($subject);
        $message = strip_tags($message);

        // Données communes à injecter dans les templates
        $context = [
            'name' => $name,
            'user_email' => $email, // ← modifié ici
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message,
        ];

        $logoPath = $this->logoPath;


        // Mail admin
        $adminMessage = (new TemplatedEmail())
            ->from(new Address('contact@ibrazainfogerance.yt', 'Ibraza Infogérance'))
            ->to($this->adminEmail)
            ->replyTo($email)
            ->subject('📩 Nouveau message reçu : [' . $subject . ']')
            ->htmlTemplate('emails/contact_admin.html.twig')
            ->context($context)
            ->embedFromPath($logoPath, 'logo_ibraza');

        $this->mailer->send($adminMessage);

        // Mail utilisateur
        $userMessage = (new TemplatedEmail())
            ->from(new Address('contact@ibrazainfogerance.yt', 'Ibraza Infogérance'))
            ->to($email)
            ->subject('✅ Confirmation de votre message à Ibraza Infogérance')
            ->htmlTemplate('emails/contact_user.html.twig')
            ->context($context)
            ->embedFromPath($logoPath, 'logo_ibraza');

        $this->mailer->send($userMessage);

    }

    public function envoyerDevis(string $type, ?string $company, string $name, string $email, string $phone, string $subject, string $message): void
    {
        $context = [
            'type' => $type,
            'company' => $company,
            'name' => $name,
            'email_user' => $email, // évite le conflit avec "email"
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message,
        ];

        $logoPath = $this->logoPath;

        $adminMessage = (new TemplatedEmail())
            ->from(new Address('contact@ibrazainfogerance.yt', 'Ibraza Infogérance'))
            ->to($this->adminEmail)
            ->replyTo($email)
            ->subject('📄 Nouvelle demande de devis : [' . $subject . ']')
            ->htmlTemplate('emails/devis_admin.html.twig')
            ->context($context)
            ->embedFromPath($logoPath, 'logo_ibraza');

        $this->mailer->send($adminMessage);

        $userMessage = (new TemplatedEmail())
            ->from(new Address('contact@ibrazainfogerance.yt', 'Ibraza Infogérance'))

            ->to($email)
            ->subject('✅ Confirmation de votre demande de devis')
            ->htmlTemplate('emails/devis_user.html.twig')
            ->context($context)
            ->embedFromPath($logoPath, 'logo_ibraza');

        $this->mailer->send($userMessage);
    }

}