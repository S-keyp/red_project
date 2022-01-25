<?php

namespace App\Controller;

use App\Entity\ProductBundle;
use App\Repository\ProductBundleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierSessionController extends AbstractController
{
    #[Route('/panier/session', name: 'panier')]
    public function index(SessionInterface $session, ProductBundleRepository $productBundleRepository): Response
    {
        $panier = $session->get("panier", []);

        $dataPanier = [];
        $total = 0;

        foreach($panier as $id => $quantite){
            $produit = $productBundleRepository->find($id);
            $dataPanier[] = [
                "produit" => $produit,
                "quantite" => $quantite,
            ];
            $total += $produit->getServicePrice() * $quantite;
        }

        return $this->render('panier_session/panier.html.twig', compact("dataPanier", "total"));
    }

    #[Route('/panier/add/{id}' , name: 'add')]
    public function add(ProductBundle $produit, SessionInterface $session){

       $panier = $session->get("panier", []);
        $id = $produit->getId();

       if(!empty($panier[$id])){
           $panier[$id]++;
       }else{
           $panier[$id] = 1;
       }

       //on sauvegarde la session
       $session->set("panier", $panier);

       return $this->redirectToRoute("panier_panier");

    }
    #[Route('/panier/remove/{id}' , name: 'remove')]
    public function remove(ProductBundle $produit, SessionInterface $session){

       $panier = $session->get("panier", []);
       $id = $produit->getId();


       if(!empty($panier[$id])){
           if($panier[$id] > 1){
               $panier[$id]--;
           }else{
               unset($panier[$id]);
           }
       }

       //on sauvegarde la session
       $session->set("panier", $panier);

       return $this->redirectToRoute("panier_panier");

    }
    #[Route('/panier/delete/{id}' , name: 'delete')]
    public function delete(ProductBundle $produit, SessionInterface $session){

       $panier = $session->get("panier", []);
       $id = $produit->getId();


       if(!empty($panier[$id])){
            unset($panier[$id]);
        }
       

       //on sauvegarde la session
       $session->set("panier", $panier);

       return $this->redirectToRoute("panier_panier");

    }
    
}
