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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
    public function FormulaireUser(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passhash): Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passhash->hashPassword($user, $user->getPassword()));

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
    public function search(Request $request, ProBundlesRepository $proFiche, UserRepository $users, PaginatorInterface $paginator): Response
    {

        //Elements par pages
        $searchCriteria = "";
        /*Paramètrage de la recherche query builder */
        $searchResults = $proFiche->createQueryBuilder('f')
            ->select('f.servicePrice, f.serviceCategory, f.Professionnal, f.descriptionService');

        if ($request->isMethod('get')) {

            $searchCriteria = $request->request->all();
            if ($request->get('order')) {
                $searchResults->orderBy('f.servicePrice', $request->get('order'));
            }
            if ($request->get('metier')) {
                $searchResults->where('f.serviceCategory = ' . $request->get('metier'));
            }
        }


        /*Récupération des résultats*/
        $query = $searchResults
            ->getQuery();
        //Load variable qui stocke les users
        $res = $query->execute();


        //pagination 
        for ($i = 0; $i < count($res); $i++) {
            $res[$i]['serviceCategory'] = $proFiche->getJob($res[$i]['serviceCategory']);
            $res[$i]['name'] = $users->fetchById($res[$i]['Professionnal']);
        }

        $pagination = $paginator->paginate(
            $res,
            $request->query->getInt('page', 1), //Numero de page get page
            3 // Elements par pages
        );

        return $this->render('professional/pro.html.twig', [
            'controller_name' => 'ProfessionalController',
            'search' => $searchCriteria,
            'searchResults' => $pagination
        ]);
    }

    #[Route("/professional/new", name: "proform")]
    public function FormulairePro(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passhash): Response
    {
        $professional = new User();
        $form = $this->createForm(ProfessionalFormType::class, $professional);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $professional->setRoles(['ROLE_PRO', 'ROLE_USER']);
            $professional->setPassword($passhash->hashPassword($professional, $professional->getPassword()));
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


    /* Quelqu'un qui est redirigé depuis la page des résultats ici */
    #[Route("/professional/{id}", name: "fichepro")]
    public function show(User $user, EntityManagerInterface $entityManager, Request $request, ProBundlesRepository $proBundlesRepository): Response
    {
        $bundles = "";
        $bundles = $proBundlesRepository->findBy(['Professionnal' => $user->getId()]);
        // var_dump($bundles[0]);
        // $bundles['serviceCategory'] = $proBundlesRepository->getJob($bundles['serviceCategory']);
        return $this->render('formulaires/bundleform.html.twig', [
            'title' => "Vous voici sur la page de la conférence " . $user,
            'text' => 'Voici les packs de ce professionel:',
            'user' => $user,
            'bundles' => $bundles,
        ]);
    }


    /* AJOUT PRESTA PAR LE PRO */
    #[Route("/professional/{id}/ajoutpresta", name: "modifyfichepro")]
    public function FicheBundle(User $user, EntityManagerInterface $entityManager, Request $request, ProBundlesRepository $proBundlesRepository): Response
    {
        $ficheBundle = new ProBundles();
        $form = $this->createForm(ProBundlesType::class, $ficheBundle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /*$uploadedFile = $form['image_service']->getData();*/
            $ficheBundle->setProfessionnal($user->getId());
            $entityManager->persist($ficheBundle);
            $entityManager->flush();

            return $this->redirectToRoute('modifyfichepro', ['id' => $user->getId()]);
        }

        $bundles = "";
        $bundles = $proBundlesRepository->findBy(['Professionnal' => $user->getId()]);

        return $this->render('formulaires/bundleform_display_modify.html.twig', [
            'fichebundle' => $ficheBundle,
            'form_probundles' => $form->createView(),
            'bundles' => $bundles,
            'user' => $user,
        ]);
    }

    /* SUPPRIMER LA PRESTA PAR LE PRO */
    #[Route("/professional/{id}/remove/{bundleId}", name: "remove_bundle")]
    public function removeBundle(User $user, int $bundleId, EntityManagerInterface $entityManager, Request $request, ProBundlesRepository $proBundlesRepository)
    {
        $bundle = $proBundlesRepository->find($bundleId);
        if (!$bundle) {
            throw $this->createNotFoundException(
                'Pas de bundle ayant un id :  '.$bundleId
            );
        }
        
        $entityManager->remove($bundle);
        $entityManager->flush();
    
        return $this->redirectToRoute('modifyfichepro', ['id' => $user->getId()]);
    }
}
