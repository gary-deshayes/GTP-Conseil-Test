<?php

namespace App\Event;

use App\Entity\HistoriqueConnexion;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LoginListener extends AbstractController
{

    public function onAuthenticationSuccess(InteractiveLoginEvent $event)
    {
        date_default_timezone_set('Europe/Paris');
        $user = $event->getAuthenticationToken()->getUser();
        $historique_connexion = new HistoriqueConnexion();
        $historique_connexion->setUser($user);
        $historique_connexion->setDateConnexion(new \DateTime());
        $this->getDoctrine()->getManager()->persist($historique_connexion);
        $this->getDoctrine()->getManager()->flush();    
    }
}
