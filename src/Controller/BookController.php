<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/book/add', name: 'app_book_add')]
    public function addBook(ManagerRegistry $doctrine, Request $request): Response
    {

        $book=new Book();
        $form=$this->createForm(BookType::class,$book);
        $form->add('add',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$doctrine->getManager();
            $em->persist($book);
            $em->flush();
        }
        return $this->render("book/add.html.twig",
        ['f'=>$form->createView()] );
    }

    #[Route('/book/list', name: 'app_book_list')]
    public function listBook(ManagerRegistry $doctrine, Request $request): Response
    {
        $repo=$doctrine->getRepository(Book::class);
        $books=$repo->findAll();

        return $this->render("book/list.html.twig", ['listBook'=>$books]);
    }
    #[Route('/book/enabled', name: 'app_book_enabled')]
    public function listBookEnabled(ManagerRegistry $doctrine, Request $request): Response
    {
        $repo=$doctrine->getRepository(Book::class);
        $books=$repo->findByenabled(1);

        return $this->render("book/list.html.twig", ['listBook'=>$books]);
    }
    
}
