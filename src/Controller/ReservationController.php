<?php

namespace App\Controller;

use App\Form\ReservationFormType;
use App\Service\ApiReservation;
use App\Service\ApiSeances;
use App\Service\Connecter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ReservationController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws \Exception
     */
//    #[Route('/reservation/{idSeance}', name: 'app_reservation')]
//    public function index(
//        int $idSeance,
//        SessionInterface $session,
//        Connecter $connecter,
//        Request $request,
//        ApiReservation $apiReservation,
//        ApiSeances $apiSeance
//    ): Response {
//        $erreur = "";
//        $date = "";
//        $tarif = "";
//
//        // Créer le formulaire par défaut
//        $form = $this->createForm(ReservationFormType::class);
//
//        $token = $session->get("token");
//
//        if (!$token) {
//            $erreur = "Token manquant dans la session.";
//            goto fin;
//        }
//
//        // Récupérer les infos de la séance
//        $response = $apiSeance->infoSeance($idSeance, $token);
//
//        if (isset($response["erreur"])) {
//            $erreur = "Erreur lors du chargement des données !";
//            goto fin;
//        }
//
//        // Définir la date
//        $dateBrut = $response["dateProjection"];
//        $dateTime = new \DateTime($dateBrut);
//        $date = $dateTime->format("d/m/Y à H\hi");
//        // Définir le tarif
//        $tarif = $response["tarifNormal"];
//
//        // Gérer le formulaire
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $donnees = $form->getData();
//            $nbPlace = $donnees["nbPlace"];
//
//            if ($nbPlace !== "") {
//                if ($session->get("token") !== "") {
//                    $token = $session->get("token");
//                    $response = $apiReservation->reservation($idSeance, $nbPlace, $token);
//                } else {
//                    $form->addError(new FormError("Veuillez vous connecter avant de réserver une séance !"));
//                }
//
//                if (!isset($response["erreur"])) {
//                    $session->getFlashBag()->add('success', 'Votre réservation a été enregistrée avec succès !');
//                    return $this->redirectToRoute('app_accueil');
//                } else {
//                    $form->addError(new FormError($response["erreur"]));
//                }
//            }
//        }
//
//        fin:
//        return $this->render('reservation/index.html.twig', [
//            'controller_name' => 'ReservationController',
//            'connect' => $connecter->tokenExists($session),
//            'form' => $form,
//            'tarif' => $tarif,
//            'date' => $date,
//            'erreur' => $erreur,
//        ]);
//    }
}