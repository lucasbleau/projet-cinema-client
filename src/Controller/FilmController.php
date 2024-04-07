<?php

namespace App\Controller;

use App\Service\ApiFilms;
use App\Service\ConvertionHeure;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class FilmController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/', name: 'app_accueil')]
    #[Route('/film', name: 'app_film')]

    public function index(ApiFilms $filmsAffiche, ConvertionHeure $convertionHeure): Response
    {
        $filmsAffiche = $filmsAffiche->ListerFilmsAffiche();
        foreach ($filmsAffiche as $key => $film)
        {
            $filmsAffiche[$key]['dureeFilm'] = $convertionHeure->convertirEnHeure($film['dureeFilm']);
        }

        return $this->render('film/index.html.twig', [
            'controller_name' => 'FilmController',
            'films' => $filmsAffiche
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */

    #[Route('/detail-film/{id}', name: 'app_detail-film')]
    public function details(ApiFilms $apiFilms, ConvertionHeure $convertionHeure,int $id): Response
    {
        $detailFilm = $apiFilms->detailFilm($id);
        $detailFilm[0]['dureeFilm'] = $convertionHeure->convertirEnHeure($detailFilm[0]['dureeFilm']);

        return $this->render('film/detail-film.html.twig', [
            'controller_name' => 'FilmController',
            'detailFilm' => $detailFilm
        ]);
    }
}
