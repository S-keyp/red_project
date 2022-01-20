<?php

namespace App\Controller;

use App\Entity\Professional;
use App\Form\ProfessionalFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfessionalController extends AbstractController
{
    #[Route('/professional', name: 'professional')]
    public function index(): Response
    {
        return $this->render('professional/pro.html.twig', [
            'controller_name' => 'ProfessionalController',
        ]);
    }

    /**
     * @Route("/professional/new", name="proform")
     */
    public function FormulairePro(Request $request, EntityManagerInterface $entityManager): Response
    {
        $professional = new Professional();
        $form = $this->createForm(ProfessionalFormType::class, $professional);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($professional);
            $entityManager->flush();
        }
        return $this->render('formulaires/proform.html.twig', [
            'professional'=>$professional,
            'form_professional' => $form->createView()
        ]);
    }
}
