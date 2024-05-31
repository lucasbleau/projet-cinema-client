<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiReservations
{
    private HttpClientInterface $httpClient;

    /**
     * @param HttpClientInterface $httpClient
     */

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function reservation(int $idSeance,int $nombrePlace, string $token) : array
    {
        $donnees = [
            'idSeance' => $idSeance,
            'nombrePlace' => $nombrePlace
        ];

        try {
            $responseAPI = $this->httpClient->request(
                'POST',
                'http://192.168.1.177:8000/api/reserverSeance',
//                'http://172.16.205.126:8000/api/reserverSeance',
//                [
//                    'json' => $donnees,
//                    'headers' => [
//                        'Authorization' => 'Bearer '.$token,
//                    ],
//                ],
                [
                    'json' => $donnees,
                    'headers' => ['Content-Type' => 'application/json', 'Authorization' => 'Bearer '.$token,],
                    'verify_peer' => false,
                    'verify_host' => false
                ]
            );
            return $responseAPI->toArray();
        } catch (ClientExceptionInterface $exception) {
            $statusCode = $exception->getResponse()->getStatusCode();
            $messageErreur = $exception->getResponse()->getContent(false);
            return ['erreur' => $messageErreur,'code' => $statusCode];
        }
    }

    public function infoSeance(int $id) : array
    {
        $rep = $this->httpClient->request(
            'GET',
//             'http://172.16.205.126:8000/api/reserverSeance/'.$id
            'http://192.168.1.177:8000/api/reserverSeance/'.$id,
            ['headers' => ['Content-Type' => 'application/json'], 'verify_peer' => false, 'verify_host' => false]
        );
        return $rep->toArray();
    }

}