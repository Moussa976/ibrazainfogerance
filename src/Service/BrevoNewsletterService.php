<?php

// src/Service/BrevoNewsletterService.php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class BrevoNewsletterService
{
    private string $apiKey;
    private string $listId;
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client, string $brevoApiKey, string $brevoListId)
    {
        $this->client = $client;
        $this->apiKey = $brevoApiKey;
        $this->listId = $brevoListId;
    }

    public function subscribe(string $email): bool
    {
        $response = $this->client->request('POST', 'https://api.brevo.com/v3/contacts', [
            'headers' => [
                'api-key' => $this->apiKey,
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ],
            'json' => [
                'email' => $email,
                'listIds' => [(int) $this->listId],
                'updateEnabled' => true,
            ]
        ]);

        return in_array($response->getStatusCode(), [201, 204]);
    }
}
