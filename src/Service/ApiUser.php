<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ApiUser
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function inscription(string $email, string $password): array
    {
        $donnees = [
            'email' => $email,
            'password' => $password
        ];

        try {
            $responseAPI = $this->httpClient->request(
                'POST',
                'http://192.168.1.177:8000/api/inscription',
//                'http://172.16.205.126:8000/api/inscription',

//                ['json' => $donnees]

                [
                    'json' => $donnees,
                    'headers' => ['Content-Type' => 'application/json'],
                    'verify_peer' => false,
                    'verify_host' => false
                ]
            );
            return $responseAPI->toArray();
        } catch (ClientExceptionInterface $exception) {
            $statusCode = $exception->getResponse()->getStatusCode();
            $messageErreur = $exception->getResponse()->getContent(false);
            return ['erreur' => $messageErreur, 'code' => $statusCode];
        }
    }

    public function connexion(string $email, string $password): array
    {
        $donnees = [
            'email' => $email,
            'password' => $password
        ];

        try {
            $response = $this->httpClient->request(
                'POST',
                'http://192.168.1.177:8000/api/connexion',
//                'http://172.16.205.126:8000/api/connexion',

//            ['json' => $donnees]

                [
                    'json' => $donnees,
                    'headers' => ['Content-Type' => 'application/json'],
                    'verify_peer' => false,
                    'verify_host' => false
                ]
            );
            $data = $response->toArray();
            return $data;
        } catch (\Exception $exception) {
            $statusCode = $exception->getResponse()->getStatusCode();
            $messageErreur = $exception->getResponse()->getContent(false);
            return ['erreur' => $messageErreur, 'code' => $statusCode];
        }
    }
}
