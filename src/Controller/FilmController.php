<?php

namespace App\Controller;

use App\Service\ApiFilms;
use App\Service\ConvertionHeure;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
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
}
