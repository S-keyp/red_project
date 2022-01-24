<?php

namespace App\Controller;


use App\Entity\ProBundles;
use App\Entity\User;
use App\Form\ProBundlesType;
use App\Form\ProfessionalFormType;
use App\Form\UserFormType;
use App\Repository\ProBundlesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
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
            return $this->redirectToRoute('modify_user', ['id' => $user->getId()]);
        }
        return $this->render('formulaires/userform.html.twig', [
            'user' => $user,
            'form_user' => $form->createView()
        ]);
    }

    /* permet de réafficher la page d'un utilisateur pour modification */
    #[Route("/user/modify/{id}", name: "modify_user")]
    public function modifyUser(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('modify_user', ['id' => $user->getId()]);
        }
        return $this->render('formulaires/userform.html.twig', [
            'user' => $user,
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
    public function search(Request $request, ProBundlesRepository $proFiche, UserRepository $users): Response
    {

        //Elements par pages

        $searchCriteria = "";
        /*Paramètrage de la recherche query builder */
        $searchResults = $proFiche->createQueryBuilder('f')
            ->select('f.servicePrice, f.serviceCategory, f.Professionnal, f.descriptionService');

        if ($request->isMethod('post')) {
            $searchCriteria = $request->request->all();
            if ($searchCriteria['order'] != "") {
                $searchResults->orderBy('f.servicePrice', $searchCriteria['order']);
            }

            if ($searchCriteria['metier']) {
                $searchResults->where('f.serviceCategory = ' . $searchCriteria['metier']);
            }
        }

        /*Récupération des résultats*/
        $query = $searchResults
            ->getQuery();

        //Load variable qui stocke les users
        $res = $query->execute();
        for ($i = 0; $i < count($res); $i++) {
            $res[$i]['serviceCategory'] = $proFiche->getJob($res[$i]['serviceCategory']);
            $res[$i]['name'] = $users->fetchById($res[$i]['Professionnal']);
        }


        return $this->render('professional/pro.html.twig', [
            'controller_name' => 'ProfessionalController',
            'search' => $searchCriteria,
            'searchResults' => $res
        ]);
    }

    #[Route("/professional/new", name: "proform")]
    public function FormulairePro(Request $request, EntityManagerInterface $entityManager): Response
    {
        $professional = new User();
        $form = $this->createForm(ProfessionalFormType::class, $professional);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $professional->setRoles(['ROLE_PRO', 'ROLE_USER']);
            $entityManager->persist($professional);
            $entityManager->flush();

            return $this->redirectToRoute('modify_pro', ['id' => $professional->getId()]);
        }
        return $this->render('formulaires/proform.html.twig', [
            'professional' => $professional,
            'form_professional' => $form->createView()
        ]);
    }


    /* permet de réafficher la page d'un pro pour modification */
    #[Route("/professional/modify/{id}", name: "modify_pro")]
    public function modifyPro(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfessionalFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('modify_pro', ['id' => $user->getId()]);
        }
        return $this->render('formulaires/proform.html.twig', [
            'professional' => $user,
            'form_professional' => $form->createView()
        ]);
    }


    #[Route("/professional/{id}", name: "fichepro")]
    public function show(User $user, ProBundlesRepository $proBundlesRepository, Request $request): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $proBundlesRepository->getBundlesPaginator($user, $offset);

        return $this->render('conference/show.html.twig', [
            'title' => "Vous voici sur la page de la conférence " . $user,
            'text' => 'Voici les packs de ce professionel:',
            'user' => $user,
            'comments' => $paginator,
            'previous' => $offset - ProBundlesRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + ProBundlesRepository::PAGINATOR_PER_PAGE),
        ]);
    }


    #[Route("/professional/{id}/ajoutpresta", name: "fichepro")]
    public function FicheBundle(EntityManagerInterface $entityManager, Request $request): Response
    {
        $ficheBundle = new ProBundles();
        $form = $this->createForm(ProBundlesType::class, $ficheBundle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /*$uploadedFile = $form['image_service']->getData();*/

            $entityManager->persist($ficheBundle);
            $entityManager->flush();
        }
        return $this->render('formulaires/bundleform.html.twig', [
            'fichebundle' => $ficheBundle,
            'form_probundles' => $form->createView()
        ]);
    }
}
