<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SearchType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminInterfaceController extends AbstractController
{
    /* INTERFACE ADMIN */
    #[Route('/admin/interface', name: 'admin_interface')]
    public function index(UserRepository $userRepository, Request $request): Response
    {
        $form = $this -> createForm(SearchType::class);

        if($form->handleRequest($request)->isSubmitted() && $form->isValid() ){
            $criteria = $form->getData();
            $recherche = $userRepository->search($criteria);
        }

        $users = $userRepository->findAll();
        return $this->render('admin_interface/index.html.twig', [
            'controller_name' => 'AdminInterfaceController',
            'users' => $users,
            'form' => $form->createView(),
        ]);
    }

    /* SUPPRIMER UN UTILISATEUR */
    #[Route('/admin/interface/remove/{id}', name: 'remove_user')]
    public function remove(Request $request, User $user, UserRepository $userRepository): Response
    {

        $id = (int)$request->query->get('id');
        $user = $userRepository->find($id);

        
        return $this->redirectToRoute('admin_interface');
    }
    /* AFFICHER UN UTILISATEUR */
    /* #[Route('/admin/interface/show/{id}', name: 'show_user')]
    public function show( UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('admin_interface/index.html.twig', [
            'controller_name' => 'AdminInterfaceController',
            'users' => $users,
            
        ]);
    } */


}
