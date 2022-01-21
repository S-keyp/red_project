<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfessionalFormType;
use App\Form\UserFormType;
use App\Repository\ProBundlesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route("/user/new", name: "userform")]
    public function FormulaireUser(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->render('formulaires/userform.html.twig', [
            'user'=>$user,
            'form_user' => $form->createView()
        ]);
    }

    
    #[Route('/professional', name: 'professional')]
    public function indexPro(): Response
    {
        return $this->render('professional/pro.html.twig', [
            'controller_name' => 'ProfessionalController',
            'search' => '',
            'searchResults' => ''
        ]);
    }

    #[Route('/professional/searchresults', name: 'professionalsearch')]
    public function search(Request $request, ProBundlesRepository $proFiche, UserRepository $basePro): Response
    {
        if ($request->isMethod('post')) {
            $searchCriteria = $request->request->all();
        }

        /*Paramètrage de la recherche*/

        $searchResults = $proFiche->createQueryBuilder('f')
            ->select('f.servicePrice');
        if ($searchCriteria['order']) {
            $searchResults->orderBy('f.servicePrice', $searchCriteria['order']);
        }
        $query = $searchResults->getQuery();



        return $this->render('professional/pro.html.twig', [
            'controller_name' => 'ProfessionalController',
            'search' => $searchCriteria,
            'searchResults' => $query->execute()
        ]);
    }



    #[Route("/professional/new", name: "proform")]
    public function FormulairePro(Request $request, EntityManagerInterface $entityManager): Response
    {
        $professional = new User();
        $form = $this->createForm(ProfessionalFormType::class, $professional);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($professional);
            $entityManager->flush();
        }
        return $this->render('formulaires/proform.html.twig', [
            'professional' => $professional,
            'form_professional' => $form->createView()
        ]);
    }



    #[Route("professional/fiche", name: "fichepro")]
    public function FichePro(Request $request): Response
    {
        return $this->render('professional/profiche.html.twig', [
            'controller_name' => 'ProfessionalController',
            'search' => ''
        ]);
    }
}

