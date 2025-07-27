<?php

// src/Service/BrevoMailerService.php
namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class BrevoMailerService
{
    private $client;
    private $apiKey;

    private LoggerInterface $logger;

public function __construct(HttpClientInterface $client, string $apiKey, LoggerInterface $logger)
{
    $this->client = $client;
    $this->apiKey = $apiKey;
    $this->logger = $logger;
}



    public function envoyer(string $toEmail, string $toName, string $subject, string $htmlContent, string $fromEmail = 'contact@ibrazainfogerance.yt', string $fromName = 'Ibraza Infogérance'): bool
    {
        try {
            $response = $this->client->request('POST', 'https://api.brevo.com/v3/smtp/email', [
                'headers' => [
                    'accept' => 'application/json',
                    'api-key' => $this->apiKey,
                    'content-type' => 'application/json',
                ],
                'json' => [
                    'sender' => [
                        'name' => $fromName,
                        'email' => $fromEmail
                    ],
                    'to' => [
                        [
                            'email' => $toEmail,
                            'name' => $toName
                        ]
                    ],
                    'subject' => $subject,
                    'htmlContent' => $htmlContent
                ]
            ]);

            // Retourne vrai si code 201 (email créé/envoyé)
            return $response->getStatusCode() === 201;
        } catch (\Throwable $e) {
            // Pour voir le message d’erreur dans le navigateur ou les logs
            dump('Erreur Brevo API : ' . $e->getMessage());
            return false;
        }
    }

}
