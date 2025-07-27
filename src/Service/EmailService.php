<?php

namespace App\Service;

use App\Service\BrevoMailerService;
use Twig\Environment;

class EmailService
{
    private BrevoMailerService $brevo;
    private Environment $twig;
    private string $adminEmail;
    private string $logoPath;

    public function __construct(
        BrevoMailerService $brevo,
        Environment $twig,
        string $logoPath
    ) {
        $this->brevo = $brevo;
        $this->twig = $twig;
        $this->adminEmail = 'contact@ibrazainfogerance.yt';
        $this->logoPath = $logoPath;
    }

    public function envoyerContact(string $name, string $email, string $phone, string $subject, string $message): void
    {
        // Nettoyage basique
        $name = strip_tags($name);
        $email = strip_tags($email);
        $phone = strip_tags($phone);
        $subject = strip_tags($subject);
        $message = strip_tags($message);

        $context = [
            'name' => $name,
            'user_email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message,
            'logoPath' => $this->logoPath,
        ];

        // Envoi à l’admin
        $this->brevo->envoyer(
            $this->adminEmail,
            '📩 Nouveau message reçu : [' . $subject . ']',
            'emails/contact_admin.html.twig',
            $context
        );

        // Confirmation à l'utilisateur
        $this->brevo->envoyer(
            $email,
            '✅ Confirmation de votre message à Ibraza Infogérance',
            'emails/contact_user.html.twig',
            $context
        );
    }

    public function envoyerDevis(string $type, ?string $company, string $name, string $email, string $phone, string $subject, string $message): void
    {
        $context = [
            'type' => $type,
            'company' => $company,
            'name' => $name,
            'email_user' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message,
            'logoPath' => $this->logoPath,
        ];

        $this->brevo->envoyer(
            $this->adminEmail,
            '📄 Nouvelle demande de devis : [' . $subject . ']',
            'emails/devis_admin.html.twig',
            $context
        );

        $this->brevo->envoyer(
            $email,
            '✅ Confirmation de votre demande de devis',
            'emails/devis_user.html.twig',
            $context
        );
    }
}
