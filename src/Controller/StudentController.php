<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\ClassroomRepository;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
    #[Route('/fetch', name: 'fetch')]
    public function fetch(StudentRepository $repo):Response
    {
        $result=$repo->findAll();
        return $this->render('student/test.html.twig',[
            'response' =>$result
        ]);
    }

    #[Route('/fetch2', name: 'fetch2')]
    public function fetch2(ManagerRegistry $mr):Response
    {
        $repo=$mr->getRepository(Student::class);
        $result=$repo->findAll();
        return $this->render('student/test.html.twig',[
            'response' =>$result
        ]);
    }
    #[Route('/add', name: 'add')]
    public function add(ManagerRegistry $mr, ClassroomRepository $repo): Response
    {
        $s=new Student();
        $c=$repo->find(1);
        $s->setName('test');
        $s->setEmail('test@gmail.com');
        $s->setAge('28');
        $s->setCin('0958888');
        $s->setClassroom($c);

        $em=$mr->getManager();
        $em->persist($s);
        $em->flush();
        return $this->redirectToRoute('fetch');
    }
    #[Route('/addF', name: 'addF')]
    public function addF(ManagerRegistry $mr, ClassroomRepository $repo,Request $req): Response
    {
        $s=new Student();   // 1- instance
        $form=$this->createForm(StudentType::class,$s);//2- creation formulaire 
        $form->handleRequest($req); //anlasyser la requette http et récuperer les données 
        if($form->isSubmitted())
        {
            $em=$mr->getManager();    //3- persist+flush
            $em->persist($s);
            $em->flush();
            return $this->redirectToRoute('fetch');
        };

        return $this->render('student/add.html.twig',[
            'f'=>$form->createView()
        ]);
    }

    #[Route('/update/{id}', name: 'update')]
    public function update(ManagerRegistry $mr, StudentRepository $repo,Request $req,$id): Response
    {
        $s= $repo->find($id); // 1- récupération
        $form=$this->createForm(StudentType::class,$s);//2- creation formulaire 
        $form->handleRequest($req);
        if($form->isSubmitted())
        {
            $em=$mr->getManager();    //3- persist+flush
            $em->persist($s);
            $em->flush();
            return $this->redirectToRoute('fetch');
        };

        return $this->renderForm('student/update.html.twig',[
            'f'=>$form
        ]);
    }
    #[Route('/remove/{id}', name: 'remove')]

    public function remove(StudentRepository $repo,$id,ManagerRegistry $mr): Response
    {
    $student=$repo->find($id);
    $em=$mr->getManager();
    $em->remove($student);
    $em->flush();
    return new Response('removed');
    }
}
