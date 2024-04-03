<?php

namespace App\Service;

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

    public function ListerFilmsAffiche() : array{
        $rep = $this->httpClient->request(
            'GET',
            'http://172.16.205.126:8000/api/listerFilmsAffiche'
        );
        return $rep->toArray();
    }

    public function detailFilm(int $id) : array {
        $rep = $this->httpClient->request(
            'GET',
            'http://172.16.205.126:8000/api/detail-film/'.$id
        );
        return $rep->toArray();
    }
}