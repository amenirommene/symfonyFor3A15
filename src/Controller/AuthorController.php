<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/show/{name}', name: 'app_author_show')]
    public function showAuthor(Request $req): Response
    {
       $n=$req->get('name');
        return $this->render('author/show.html.twig', [
            'variableName' => $n,
        ]);
    }
    #[Route('/list', name: 'app_author_list')]
    public function listAuthors(AuthorRepository $repo): Response
    {
       $authors= $repo->findAll();
        // $authors = [];
      /*  $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
            ); */   
        return $this->render('author/list.html.twig', [
            'list' => $authors,
        ]);
    }

    #[Route('/add', name: 'app_author_add')]
    public function addAuthor(ManagerRegistry $doctrine, Request $request): Response
    {
        $author2=new Author();
        $author=new Author();
        
        $form=$this->createForm(AuthorType::class,$author);
        $form->add('add',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$doctrine->getManager();
            $em->persist($author);
            $em->flush();
        }
        return $this->render("author/add.html.twig",
        ['f'=>$form->createView()] );
    }

    #[Route('/update/{id}', name: 'app_author_update')]
    public function updateAuthor($id, AuthorRepository $repo
    ,ManagerRegistry $doctrine, Request $request): Response
    {
        $author=$repo->find($id);
        $form=$this->createForm(AuthorType::class,$author);
        $form->add('modifier',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$doctrine->getManager();
          //  $em->persist($author);
            $em->flush();
        }
        return $this->render("author/add.html.twig",
        ['f'=>$form->createView()] );
    }

    #[Route('/remove/{id}', name: 'app_author_remove')]
    public function removeAuthor(Author $author,ManagerRegistry $doctrine): Response
    {
        $em=$doctrine->getManager();
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute("app_author_list");
    }

    #[Route('/list2/{name}', name: 'app_author_list2')]
    public function listAuthorsByName($name, AuthorRepository $repo): Response
    {
      // $authors= $repo->findByName($name);
      $authors= $repo->findByNameDQL($name);
        // $authors = [];
      /*  $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
            ); */   
        return $this->render('author/list.html.twig', [
            'list' => $authors,
        ]);
    }
}
