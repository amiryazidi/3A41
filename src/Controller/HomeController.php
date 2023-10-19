<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    } 
    #[Route('/show', name: 'show')]
    public  function show(){
        return new Response('<h1> Bonjour </h1>');
    }
    #[Route('/msg/{name}', name: 'msg')]
    public  function msg($name){

        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
            'victor.hugo@gmail.com ', 'nb_books' => 0),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
            ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
            'taha.hussein@gmail.com', 'nb_books' => 300),
            );


        return $this->render('home/msg.html.twig',[
            'n'=>$name,
            'a'=>$authors
        ]);
    }
    #[Route('/details/{id}', name: 'd')]
    public  function details($id){
        return new Response('authors'.$id);
    }

}
