<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
    #[Route('/showService/{name}',name:'showService')]
    public function showService($name){
        return  $this->render( 'service/showService.html.twig',['param'=>$name]);
    } 
    #[Route('/goToIndex', name: 'app_index')]
    public function goToIndex(){
        return $this->render('service/goToIndex.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    } 
     
}
