<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServiceController extends AbstractController
{
    //chemin à écrire dans l'url pour exécuter la fonction
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        //retourner la vue index.html.twig sous service
        //render pointe automatiquement sur le dossier templates
        //1er argument de render : chemin vers le fichier sous templates
        //2eme argument : tableau de variables à envoyer vers la vue. 
        return $this->render('service/index.html.twig', 
        [
            'class_name' => '3A15',
        ]
    );
    }
//show : path : chaine fixe
//{name} : paramètre à envoyer dans l'url
    #[Route('/show/{name}', name: 'app_service_show')]
    public function showService($name): Response
    {
        
        return $this->render('service/showService.html.twig', 
        [
            'name' => $name,
        ]
    );
    }
}
