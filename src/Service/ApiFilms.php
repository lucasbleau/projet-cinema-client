<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiFilms
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
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function ListerFilmsAffiche() : array
    {
        $rep = $this->httpClient->request(
            'GET',
            'http://172.16.205.126:8000/api/listerFilmsAffiche'
            // 'http://192.168.1.177:8000/api/listerFilmsAffiche'

        );
        return $rep->toArray();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function detailFilm(int $id) : array
    {
        $rep = $this->httpClient->request(
            'GET',
            'http://172.16.205.126:8000/api/detail-film/'.$id
            // 'http://192.168.1.177:8000/api/detail-film/'.$id
        );
        return $rep->toArray();
    }
}