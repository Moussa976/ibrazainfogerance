<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Twig\Environment;

class BrevoMailerService
{
    private HttpClientInterface $client;
    private Environment $twig;
    private string $apiKey;

    public function __construct(HttpClientInterface $client, Environment $twig, string $apiKey)
    {
        $this->client = $client;
        $this->twig = $twig;
        $this->apiKey = $apiKey;
    }

    /**
     * Envoie un e-mail via Brevo (API HTTP)
     *
     * @param string $to Adresse du destinataire
     * @param string $subject Sujet du message
     * @param string $templatePath Chemin vers le template Twig
     * @param array $context Données à injecter dans le template
     *
     * @throws \RuntimeException en cas d'échec
     */
    public function envoyer(string $to, string $subject, string $templatePath, array $context): void
    {
        $html = $this->twig->render($templatePath, $context);

        $response = $this->client->request('POST', 'https://api.brevo.com/v3/smtp/email', [
            'headers' => [
                'accept' => 'application/json',
                'api-key' => $this->apiKey,
                'content-type' => 'application/json',
            ],
            'json' => [
                'sender' => [
                    'name' => 'Ibraza Infogérance',
                    'email' => 'contact@ibrazainfogerance.yt',
                ],
                'to' => [
                    ['email' => $to],
                ],
                'subject' => $subject,
                'htmlContent' => $html,
            ],
        ]);

        if ($response->getStatusCode() !== 201) {
            $error = $response->getContent(false); // récupère la réponse JSON même en cas d'erreur
            throw new \RuntimeException("Erreur Brevo ({$response->getStatusCode()}): $error");
        }
    }
}
