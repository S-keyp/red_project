<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        /* $isgranted=0;
        if ($this->isGranted('ROLE_ADMIN')) {
            $isgranted=1;
        }
        if ($this->isGranted('ROLE_USER')) {
            $isgranted=3;
        }
        if ($this->isGranted('ROLE_PRO')) {
            $isgranted=2;
        } */

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
