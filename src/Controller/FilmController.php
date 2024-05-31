<?php

namespace App\Controller;

use App\Service\ApiFilms;
use App\Service\ApiReservation;
use App\Service\Connecter;
use App\Service\ConvertionHeure;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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

    public function index(ApiFilms $filmsAffiche, ConvertionHeure $convertionHeure, Connecter $connecter, SessionInterface $session): Response
    {
        $filmsAffiche = $filmsAffiche->ListerFilmsAffiche();
        foreach ($filmsAffiche as $key => $film)
        {
            $filmsAffiche[$key]['dureeFilm'] = $convertionHeure->convertirEnHeure($film['dureeFilm']);
        }

        return $this->render('film/index.html.twig', [
            'controller_name' => 'FilmController',
            'films' => $filmsAffiche,
            'connect' => $connecter->tokenExists($session)
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */

//    #[Route('/detail-film/{id}', name: 'app_detail-film')]
//    public function details(ApiFilms $apiFilms, ConvertionHeure $convertionHeure, int $id, Connecter $connecter, SessionInterface $session): Response
//    {
//        $detailFilm = $apiFilms->detailFilm($id);
//        $detailFilm[0]['dureeFilm'] = $convertionHeure->convertirEnHeure($detailFilm[0]['dureeFilm']);
//
//        return $this->render('film/detail-film.html.twig', [
//            'controller_name' => 'FilmController',
//            'detailFilm' => $detailFilm,
//            'connect' => $connecter->tokenExists($session)
//        ]);
//    }
//
//    #[Route('/reserver', name: 'app_reservation')]
//    public function reserver(Request $request, ApiReservation $apiReservations, SessionInterface $session, Connecter $connecter): Response
//    {
//        $idSeance = $request->request->get('idSeance');
//        $nbPlace = $request->request->get('nbPlace');
//        $token = $session->get('token');
//
//        if ($idSeance && $nbPlace && $token) {
//            $response = $apiReservations->reservation($idSeance, $nbPlace, $token);
//
//            if (isset($response['erreur'])) {
//                // Gérer l'erreur (par exemple, ajouter un message flash)
//                $this->addFlash('error', $response['erreur']);
//            } else {
//                // Gérer le succès (par exemple, ajouter un message flash)
//                $this->addFlash('success', 'Votre réservation a été enregistrée avec succès !');
//                return $this->redirectToRoute('app_accueil');
//            }
//        } else {
//            // Gérer les données manquantes
//            $this->addFlash('error', 'Données manquantes pour la réservation.');
//        }
//
//        // Si il y a des erreur on renvoie l'erreur'
//        return $this->render('film/detail-film.html.twig', [
//            'controller_name' => 'FilmController',
//            'detailFilm' => $detailFilm,
//            'connect' => $connecter->tokenExists($session)
//        ]);
//    }

    #[Route('/detail-film/{id}', name: 'app_detail-film')]
    public function details(ApiFilms $apiFilms, ConvertionHeure $convertionHeure, ApiReservation $apiReservation, int $id,
                            Connecter $connecter, SessionInterface $session, Request $request): Response {

        // Récupérer les détails du film
        $detailFilm = $apiFilms->detailFilm($id);
        $detailFilm[0]['dureeFilm'] = $convertionHeure->convertirEnHeure($detailFilm[0]['dureeFilm']);

        // Gérer la réservation
        if ($request->isMethod('POST')) {
            $nbPlace = $request->request->get('nbPlace');
            $token = $session->get('token');
            $idSeance = $request->request->get('idSeance');

            // Vérification du token
            if (!$token) {
                $this->addFlash('error', 'Token not found in session.');
            }

            if ($idSeance && $nbPlace && $token) {
                $response = $apiReservation->reservation($idSeance, $nbPlace, $token);

                if (isset($response['erreur'])) {
                    $this->addFlash('error', $response['erreur']);
                } else {
                    $this->addFlash('success', 'Votre réservation a été enregistrée avec succès !');
                    return $this->redirectToRoute('app_accueil');
                }
            } else {
                $this->addFlash('error', 'Données manquantes pour la réservation.');
            }
        }

        return $this->render('film/detail-film.html.twig', [
            'controller_name' => 'FilmController',
            'detailFilm' => $detailFilm,
            'connect' => $connecter->tokenExists($session)
        ]);
    }

}
