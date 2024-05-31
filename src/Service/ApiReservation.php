<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiReservation
{
    private HttpClientInterface $httpClient;

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws \Exception
     */
    public function reservation(int $idSeance, int $nbPlace, string $token): array {
        $donnees = [
            'idSeance' => $idSeance,
            'nbPlace' => $nbPlace
        ];

        try {
            $responseAPI = $this->httpClient->request(
                'POST',
                'http://192.168.1.177:8000/api/reservation',
                [
                    'json' => $donnees,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Content-Type' => 'application/json'
                    ],
                    'verify_peer' => false,
                    'verify_host' => false
                ],
            );

            // Débogage : Afficher la réponse brute
            error_log('Response: ' . $responseAPI->getContent(false));

            return $responseAPI->toArray();
        } catch (ClientExceptionInterface $exception) {
            $statusCode = $exception->getResponse()->getStatusCode();
            $messageErreur = $exception->getResponse()->getContent(false);
            return ['erreur' => $messageErreur, 'code' => $statusCode];
        }
    }
}