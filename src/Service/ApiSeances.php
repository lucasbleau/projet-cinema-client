<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiSeances
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
    public function infoSeance(int $idSeance, string $token) : array {
        $donnees = [
            'idSeance' => $idSeance,
        ];

        if (!$token) {
            throw new \Exception("Token is missing.");
        } else {
            error_log("Token used: " . $token);
        }

        try {
            $responseAPI = $this->httpClient->request(
                'POST',
                'http://192.168.1.177:8000/api/info-seance',
                [
                    'json' => $donnees,
                    'headers' => ['Authorization' => 'Bearer ' . $token],
                    'verify_peer' => false,
                    'verify_host' => false
                ]
            );

            $responseData = $responseAPI->toArray();
            dump($responseData); // Débogage pour vérifier la réponse de l'API
            return $responseData;

        } catch (ClientExceptionInterface $exception) {
            $statusCode = $exception->getResponse()->getStatusCode();
            $messageErreur = $exception->getResponse()->getContent(false);
            dump($messageErreur); // Débogage pour vérifier le message d'erreur
            return ['erreur' => $messageErreur, 'code' => $statusCode];
        }
    }

}