<?php

namespace App\Controller;

use App\Form\ConnexionType;
use App\Form\InscriptionFormType;
use App\Service\ApiUser;
use App\Service\Connecter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(ApiUser $apiUser,Request $request, SessionInterface $session, Connecter $connecter): Response
    {
        $form = $this->createForm(InscriptionFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $donnees = $form->getData();
            $email = $donnees["email"];
            $password = $donnees["password"];
            $confirm = $donnees["confirmPassword"];
            if ($password == $confirm) {
                $response = $apiUser->inscription($email, $password);
            } else {
                $response["erreur"] = "Les mots de passes ne sont pas identiques !" ;
            }

            if (!isset($response["erreur"])) {
                $this->addFlash('success', 'Compte Créé !');
                return $this->redirectToRoute('app_accueil');
            } else {
                $form->addError(new FormError($response["erreur"]));
            }
        }

        // Si il y a des erreur on renvoie l'erreur'
        return $this->render('user/inscription.html.twig', [
            'form' => $form,
            'connect' => $connecter->tokenExists($session)
        ]);
    }

    #[Route('/connexion', name: 'app_connexion')]
    public function connexion(ApiUser $apiUser, Request $request, SessionInterface $session, Connecter $connecter): Response
    {
        $form = $this->createForm(ConnexionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $email = $formData['email'];
            $password = $formData['password'];

            $response = $apiUser->connexion($email, $password);

            // Gérer la réponse en conséquence
            if (isset($response['token'])) {
                // ajouter dans la session le token
                $session->set('token', $response['token']);
                $this->addFlash('success', 'Connexion réussie !');
                return $this->redirectToRoute('app_accueil');
            } else {
                $form->addError(new FormError($response["erreur"]));
            }
        }
        // Afficher le formulaire de connexion
        return $this->render('user/connexion.html.twig', [
            'form' => $form,
            'connect' => $connecter->tokenExists($session)
        ]);
    }

    #[Route('/deconnexion', name: 'app_deconnexion')]
    public function deconnexion(SessionInterface $session) : Response
    {
        $session->clear();
        $this->addFlash('success', 'Vous êtes déconnecter !');
        return $this->redirectToRoute('app_accueil');
    }

}