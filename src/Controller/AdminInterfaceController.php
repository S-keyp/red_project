<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SearchNameType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminInterfaceController extends AbstractController
{
    /* INTERFACE ADMIN */
    #[Route('/admin/interface', name: 'admin_interface')]
    public function index(UserRepository $userRepository, Request $request): Response
    {
        $form = $this->createForm(SearchNameType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $f = $form->getData();
            $users = $userRepository->findBy(['firstname' => $f]);
            

            return $this->render('admin_interface/index.html.twig', [
                'controller_name' => 'AdminInterfaceController',
                'users' => $users,
                'form' => $form->createView(),
            ]);
        }

        $users = $userRepository->findAll();

        return $this->render('admin_interface/index.html.twig', [
            'controller_name' => 'AdminInterfaceController',
            'users' => $users,
            'form' => $form->createView(),
        ]);
    }

    /* SUPPRIMER UN UTILISATEUR */
    #[Route('/admin/interface/remove', name: 'remove_user')]
    public function remove(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $id = (int)$request->query->get('id');
        $user = $userRepository->find($id);
        
        if (!$user) {
            throw $this->createNotFoundException(
                'Pas d\'utilisateur ayant un id :  '.$id
            );
        }
        
        $entityManager->remove($user);
        $entityManager->flush();
    
        return $this->redirectToRoute('admin_interface'); 
    }
}
