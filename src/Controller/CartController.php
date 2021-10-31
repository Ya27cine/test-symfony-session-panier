<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Card\CardService;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(SessionInterface $session, ProductRepository $productRepository)
    {

        $mon_panier = $session->get('product', []);

        $panierWithData = [];

        foreach ($mon_panier as $id => $value) {
            $panierWithData[] = [
                    'prodcut' => $productRepository->find( $id ),
                    'Quantity' => $value
            ]; 
        }

        $total_panier  = 0;
        foreach ($panierWithData as $item) {
            $total_panier += $item['prodcut']->getPrice() * $item['Quantity'];
        }
        var_dump($total_panier);

        dd($panierWithData);

        return $this->render('cart/index.html.twig', []);
    }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, CardService $card){
        $card->add($id);
        dd('success');
    }

    /**
     * @Route("/panier/remove", name="cart_destr")
     */
    public function remove( SessionInterface $session){
        $session->remove('product');
        dd('remove');
    }
}

?>