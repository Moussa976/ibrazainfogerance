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

            // DUMP la réponse brute de l’API Brevo (contenu + code HTTP)
            dump('Status: ' . $response->getStatusCode());
            dump('Body: ' . $response->getContent(false)); // false = désactive le throw
            die(); // bloque ici pour lecture directe

            return $response->getStatusCode() === 201;
        } catch (\Throwable $e) {
            dump('Erreur API : ' . $e->getMessage());
            die();
        }
    }


}
