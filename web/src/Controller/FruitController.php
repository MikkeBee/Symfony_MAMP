<?php

namespace App\Controller;

use App\Entity\Fruits;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use function Symfony\Component\String\u;


class FruitController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(EntityManagerInterface $em): Response
    {
        $fruits = $em->getRepository(Fruits::class)->findAll();
        
        return $this->render('fruit/index.html.twig',['fruits'=>$fruits]);
    }

    #[Route('/create', name: 'create_fruit', methods: ['POST'])]
    public function create(Request $request, ManagerRegistry $doctrine):
    Response
    {
        $fruitname = trim($request->get('fruitname'));
        $color = trim($request->get('color'));
        $taste = trim($request->get('taste'));
        if (!empty($fruitname && $color)) {
            $entityManager = $doctrine->getManager();
            $fruit = new Fruits();
            $fruit->setFruitname($fruitname);
            $fruit->setColor($color);
            $fruit->setTaste($taste);
            $entityManager->persist($fruit);
            $entityManager->flush();
            return $this->redirectToRoute('homepage');
        } else {
            return $this->redirectToRoute('homepage');
        }
    }

    #[Route('/update/{id}', name:'update_fruit')]
    public function update(Request $request, $id, ManagerRegistry $doctrine): Response
{
    $fruitname =trim($request->get('fruitname'));
    $color =trim($request->get('color'));
    $taste =trim($request->get('taste'));
    $em = $doctrine->getManager();
    $fruit=$em->getRepository(Fruits::class)->find($id);
    $fruit->setFruitname($fruitname);
    $fruit->setColor($color);
    $fruit->setTaste($taste);
    $em->flush();

    return $this->redirectToRoute('homepage');

}


    #[Route('/delete/{id}', name: 'delete_fruit')]
    public function delete($id, ManagerRegistry $doctrine): Response
    {
        //18. copypaste the update code fix task => id, remove($id)
        $entityManager = $doctrine->getManager();
        $id = $entityManager->getRepository(Fruits::class)->find($id);
        $entityManager->remove($id);
        $entityManager->flush();
        return $this->redirectToRoute('homepage');
        // exit('crud delete task: update a new task' . $id);

        //19. test remove works

    }

}