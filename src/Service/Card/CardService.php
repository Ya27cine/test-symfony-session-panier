<?php 
namespace App\Service\Card;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardService{

    private $session;
    private $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function add($id){
        $mon_panier = $this->session->get('product', []);
        if( isset($mon_panier[$id]) )
                $mon_panier[$id]++;
        else
                $mon_panier[$id] = 1;
        $this->session->set('product', $mon_panier);
    }


    public function fullCard(){
        $mon_panier = $this->session->get('product', []);

        $panierWithData = [];

        foreach ($mon_panier as $id => $value) {
            $panierWithData[] = [
                    'product' => $this->productRepository->find( $id ),
                    'Quantity' => $value
            ]; 
        }

        return $panierWithData;
    }

    public function total($panierWithData){
        $total_panier = 0.0;
        foreach ($panierWithData as $item) {
            $total_panier += $item['product']->getPrice() * $item['Quantity'];
        }
        return $total_panier;
    }

    public function remove($id){
        $mon_panier = $this->session->get('product', []);

        if( isset($mon_panier[$id]) )
                 unset($mon_panier[$id]);
        
        $this->session->set('product', $mon_panier);
    }

}

?>