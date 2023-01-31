<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; # Importation de la classe de contrôleur de base de Symfony
use Symfony\Component\HttpFoundation\Response; # Importation de la classe de réponse HTTP de Symfony
use Symfony\Component\Routing\Annotation\Route; # Importation de l'annotation de route de Symfony

class HomeController extends AbstractController{ # Définition de la classe HomeController
    #[Route('/','home.index',methods:['GET'])]
    public function index(): Response{ # Définition de la méthode index() qui gère la route "/"
        return $this->render('pages/home.html.twig'); # Renvoie de la réponse en utilisant le modèle de vue "pages/home.html.twig"
    }

}
