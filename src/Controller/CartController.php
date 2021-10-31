<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Card\CardService;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CardService $card)
    {
        $panierWithData = $card->fullCard();

        $total_panier  = $card->total( $panierWithData );
        
        return $this->render('cart/index.html.twig', [
            'panier' => $panierWithData,
            'total' => $total_panier
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, CardService $card){
        $card->add($id);
        dd('success');
    }

    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, CardService $card){
        $card->remove($id);

        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/panier/delete", name="cart_delete")
     */
    public function delete( SessionInterface $session){
        $session->remove('product');
        dd('remove');
    }
}

?>