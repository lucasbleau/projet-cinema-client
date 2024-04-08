<?php

namespace App\Controller;

use App\Form\InscriptionFormType;
use App\Service\ApiUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(ApiUser $apiUser,Request $request): Response
    {
        $form = $this->createForm(InscriptionFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $donnees = $form->getData();
            $email = $donnees["email"];
            $password = $donnees["password"];
            $response = $apiUser->inscription($email,$password);

            if (!isset($response["erreur"]))
            {
                return $this->redirectToRoute('app_accueil');
            }
            else
            {
                $form->get('email')->addError(new FormError($response["erreur"]));
            }
        }

        // Si il y a des erreur on renvoie l'erreur'
        return $this->render('user/inscription.html.twig', [
            'form' => $form,
        ]);
    }
}