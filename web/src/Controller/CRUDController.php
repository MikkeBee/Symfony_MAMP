<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class CRUDController extends AbstractController
{
    #[Route('/crud/list', name: 'crud')]
    public function index(EntityManagerInterface $em): Response
    {
        $tasks = $em->getRepository(Task:: class)->findAll();
        return $this->render('crud/index.html.twig', ['tasks'=>$tasks]);

    }

    #[Route('/create', name: 'create_task', methods: ['POST'])]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $title = trim($request->get("title"));
        if(!empty($title)) {
        $entityManager = $doctrine->getManager();
        $task = new Task();
        $task->setTitle($title);
        $entityManager->persist($task); //preparing for saving in db
        $entityManager->flush(); // saving is done by this  line, insert in db
        return new Response("task added");
        } else {
        return $this->redirectToRoute('crud');
        }
    }

    #[Route('/update/{id}', name: 'update_task')]
    public function update($id): Response
    {
        exit('crud update: update task' . $id);

    }

    #[Route('/delete/{id}', name: 'delete_task')]
    public function delete($id): Response
    {
        exit('crud update: update task' . $id);

    }
}
