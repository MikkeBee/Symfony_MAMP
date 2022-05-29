<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EasyController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {

        return $this->render('easy/index.html.twig');
    }

    #[Route('/aboutme', name: 'AboutMe')]
    public function aboutme(): Response
    {
        $languages = ['React', 'Javascript', 'HTML', 'CSS'];


        return $this->render('easy/about.html.twig', ['languages'=>$languages]);
    }

    #[Route('/contact', name: 'contactme')]
    public function contact(): Response
    {
        return $this->render('easy/contact.html.twig');
    }
}
