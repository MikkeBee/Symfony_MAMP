<?php

namespace App\Controller;

use App\Entity\Task; // Should be imported with new Task
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function Symfony\Component\String\u;

class CRUDController extends AbstractController
{
    // 7. Entitny manager, change name to crud
    #[Route('/', name: 'crud')]
    public function index(EntityManagerInterface $em): Response
    {
        // 8. I have no idea what this does moving our task from create to list ?
        
        // 20.
        // $tasks = $em->getRepository(Task::class)->findAll(); moves the last added item to front
        $tasks = $em->getRepository(Task::class)->findBy([], ['id'=>'DESC']);
        
        return $this->render('crud/index.html.twig',['tasks'=>$tasks]);
    }

    #[Route('/create', name: 'create_task', methods: ['POST'])]
    // 2. add request and request title
    public function create(Request $request,ManagerRegistry $doctrine): Response
    {   
        
        $title = trim($request->get('title'));
        if(!empty($title)){
            $entityManager = $doctrine->getManager();
            $task = new Task();
            $task->setTitle($title);
            $entityManager->persist($task);
            $entityManager->flush();
            return new Response("task added");
        } else {
            return $this->redirectToRoute('crud');
        }
    }
    // this needs to be here if it doesnt work
    //      //3. Add validation
    //     $title = trim($request->get('title'));
    //     //4. entitymanager ManagerRegistry ^
    //     $entityManager = $doctrine->getManager(); // this comes from Task.php
    //     $task = new Task();
    //     $task->setTitle($title);
    //     $entityManager->persist($task); //prepearing for saving in db
    //     $entityManager->flush(); // saving is done by this line, insert in db
    //     // now test input field (it should post it to database)
    //    //3. Add validation
    //     if(empty($title)){
    //     return $this->redirectToRoute('c_r_u_d');
    // exit($request->get('title'));
    


    // 16. entitymanager $doctrine
    #[Route('/update/{id}', name: 'update_task')]
    public function update($id, ManagerRegistry $doctrine): Response
    {
        // 17. re writing update, after this it should overline the line and then database says 0 for false and 1 true(checked css)
        $entityManager = $doctrine->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);
        $task->setStatus(!$task->getStatus());
        $entityManager->flush();
        return $this->redirectToRoute('crud');

        // exit('crud update task: update a new task' . $id);
    }


    #[Route('/delete/{id}', name: 'delete_task')]
    public function delete($id, ManagerRegistry $doctrine): Response
    {
        //18. copypaste the update code fix task => id, remove($id)
        $entityManager = $doctrine->getManager();
        $id = $entityManager->getRepository(Task::class)->find($id);
        $entityManager->remove($id);
        $entityManager->flush();
        return $this->redirectToRoute('crud');
        // exit('crud delete task: update a new task' . $id);

        //19. test remove works

    }
}
