<?php

namespace App\Controller;

use App\Entity\User; # Importation de l'entité User
use App\Form\RegistrationFormType; # Importation du type de formulaire d'inscription
use App\Security\UserAuthenticator; # Importation de l'authentificateur d'utilisateur
use Doctrine\ORM\EntityManagerInterface; # Importation du gestionnaire d'entités Doctrine
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; # Importation de la classe de contrôleur de base de Symfony
use Symfony\Component\HttpFoundation\Request; # Importation de la classe de requête HTTP de Symfony
use Symfony\Component\HttpFoundation\Response; # Importation de la classe de réponse HTTP de Symfony
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; # Importation de l'interface de hachage de mot de passe d'utilisateur
use Symfony\Component\Routing\Annotation\Route; # Importation de l'annotation de route de Symfony
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface; # Importation de l'interface d'authentification d'utilisateur
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController # Définition de la classe RegistrationController
{
    #[Route('/inscription', name: 'register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response # Définition de la méthode register() qui gère la route "/inscription"
    {
        $user = new User(); # Création d'un nouvel objet User
        $form = $this->createForm(RegistrationFormType::class, $user); # Création d'un formulaire d'inscription à partir de l'objet User
        $form->handleRequest($request); # Traitement de la requête pour remplir le formulaire

        if ($form->isSubmitted() && $form->isValid()) { # Vérification si le formulaire a été soumis et est valide
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user); # Enregistrement de l'utilisateur en base de données
            $entityManager->flush(); # Sauvegarde des modifications
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            ); # Authentification de l'utilisateur
        }

        return $this->render('registration/register.html.twig', [ # Affichage du formulaire d'inscription
            'registrationForm' => $form->createView(),
        ]);
    }
}
