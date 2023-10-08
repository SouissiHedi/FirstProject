<?php

namespace App\Controller;

use App\Form\AuthorformType;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Author;

class AuthorController extends AbstractController
{
    public $authors = array(


        array(
            'id' => 1, 'picture' => '/images/Victor-Hugo.jpg',
            'username' => ' Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100
        ),
        array(
            'id' => 2, 'picture' => '/images/william-shakespeare.jpg',
            'username' => ' William Shakespeare', 'email' => ' william.shakespeare@gmail.com', 'nb_books' => 200
        ),
        array(
            'id' => 3, 'picture' => '/images/Taha_Hussein.jpg',
            'username' => ' Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300
        ),
    );

    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/author/{n}', name: 'app_show')]
    public function showAuthor($n){
      return $this->render('author/show.html.twig',['name'=>$n]);
    }

    #[Route('/list',name: 'list')]
    public function list(){
        $authors = array(
            array('id' => 1, 'picture' => 'images/victor-hugo.jpg','username' => 'Victor Hugo', 'email' =>
                'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => 'images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
                ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => 'images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
                'taha.hussein@gmail.com', 'nb_books' => 300),
        );
    return $this->render('author/list.html.twig',['authors'=>$authors]);
    }
    #[Route('/show/{id}',name: 'show')]
    public function auhtorDetails ($id)
    {
        $author = null;
        // Parcourez le tableau pour trouver l'auteur correspondant à l'ID
        foreach ($this->authors as $authorData) {
            if ($authorData['id'] == $id) {
                $author = $authorData;
            };
        };
        return $this->render('author/showAuthor.html.twig', [
            'author' => $author,
            'id' => $id
        ]);
    }

    #[Route('/listAuthor',name:'list_author')]
    public function listAuthor(AuthorRepository $authorepository) : Response{
        $list = $authorepository->findAll();
        return $this->render('author/listAuthor.html.twig',['list' =>$list]);
    }

    #[Route("/ajouter-auteur", name:"ajouter_auteur")]
    public function ajouterAuteur(AuthorRepository $authorepository): Response
    {
        $author = new Author();
        $author->setUsername("hchix");
        $author->setEmail("hchix@marsaouifildem.tn");
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($author);
        $em->flush();
        return $this->render('author/statAuthorAdd.html.twig',['author' =>$author]);
    }

    #[Route("/form", name:"formAuteur")]
    public function AddAuthor (Request $request){
        $author =new Author();
        $form = $this->createForm(AuthorformType::class,$author);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('list_author');
        }
        return $this->render('author/form.html.twig', ['formA' => $form->createView()]);
    }


}