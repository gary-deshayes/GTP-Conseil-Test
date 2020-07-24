<?php

namespace App\Controller\Admin;

use App\Repository\TacheRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * Le Dashboard de l'administration
     * @Route("/admin", name="admin")
     */
    public function index(UserRepository $userRepository, TacheRepository $tacheRepository)
    {
        return $this->render('admin/index.html.twig', [
            'nbEmployes' => $userRepository->nbEmployee()["nb"],
            'tacheEnAttente' => $tacheRepository->getNbTacheByEtat(0)['nb'],
            'tacheEnCours' => $tacheRepository->getNbTacheByEtat(1)['nb']
        ]);
    }
}
