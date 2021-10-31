<?php 
namespace App\Service\Card;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardService{

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function add($id){

        $mon_panier = $this->session->get('product', []);

        if( isset($mon_panier[$id]) )
                $mon_panier[$id]++;
        else
                $mon_panier[$id] = 1;

        $this->session->set('product', $mon_panier);
    }

}

?>