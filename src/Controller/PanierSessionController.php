<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\ProBundles;
use App\Entity\User;
use App\Repository\OrderRepository;
use App\Repository\ProBundlesRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\ManagerRegistry as DoctrineManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route("/cart", name: "cart_")]

class PanierSessionController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, ProBundlesRepository $proBundlesRepository): Response
    {
        $panier = $session->get("panier", []);

        $dataPanier = [];
        $total = 0;

        foreach ($panier as $id => $quantite) {
            $produit = $proBundlesRepository->find($id);
            $dataPanier[] = [
                "proBundles" => $produit,
                "quantite" => $quantite,

            ];
            $total += $produit->getServicePrice() * $quantite;
        }

        return $this->render('cart/index.html.twig', compact("dataPanier", "total"));
    }

    #[Route('/cart/add/{id}', name: 'add')]
    public function add(ProBundles $produit, SessionInterface $session)
    {

        $panier = $session->get("panier", []);
        $id = $produit->getId();

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        //on sauvegarde la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }





    #[Route('/cart/remove/{id}', name: 'remove')]
    public function remove(ProBundles $produit, SessionInterface $session)
    {

        $panier = $session->get("panier", []);
        $id = $produit->getId();


        if (!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }

        //on sauvegarde la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }
    #[Route('/panier/delete/{id}', name: 'delete')]
    public function delete(ProBundles $produit, SessionInterface $session)
    {

        $panier = $session->get("panier", []);
        $id = $produit->getId();


        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }


        //on sauvegarde la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }




    #[Route('/confirm/', name: 'confirm_cart')]
    public function confirm(SessionInterface $session, ProBundlesRepository $proBundlesRepository, ManagerRegistry $doctrine)
    {

        $panier = $session->get("panier", []);
        //$id = $produit->getId();

        //On enregistre les données en base

        $dataPanier = [];
        $total = 0;
        foreach ($panier as $id => $quantite) {
            $produit = $proBundlesRepository->find($id);
            $dataPanier[] = [
                "proBundles" => $produit,
                "quantite" => $quantite,

            ];
            $total += $produit->getServicePrice() * $quantite;

           $pro = $proBundlesRepository->findOneBy(array('id' => $id));


 $manager = $doctrine->getManager();

             $orderData = new Order();

             $orderData->setProductId($pro->getId());
            $orderData->setProfessionalId($pro->getProfessionnal());
            $orderData->setTotal($pro->getServicePrice() * $quantite);
           $orderData->setQuantity($quantite);
           $orderData->setIdUtilisateur($this->getUser()->getUserIdentifier());

          $manager->persist($orderData);

//            //save donnés 
            $manager->flush();
        }


        //On clear les donnés du panier
        $session->remove("panier");

        return $this->render('cart/confirm.html.twig',);

    }




    public function addOrder(){
    }
}
