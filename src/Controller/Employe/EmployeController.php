<?php

namespace App\Controller\Employe;

use App\Entity\LiaisonTacheUser;
use App\Entity\Tache;
use App\Repository\HistoriqueConnexionRepository;
use App\Repository\TacheRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeController extends AbstractController
{
    /**
     * @Route("/employe", name="employe")
     */
    public function index(TacheRepository $tacheRepository)
    {
        $tacheActuelle = $tacheRepository->getTacheActuelle($this->getUser());
        return $this->render('employe/index.html.twig', [
            "taches" => $tacheRepository->getTacheNonPrise(),
            "tacheActuelle" => $tacheActuelle
        ]);
    }

    /**
     * Permet d'attribuer une tâche à un employé
     * @Route("/employe/prendre_tache/{tache}", name="employe_prendre_tache", methods={"POST"})
     */
    public function prendre_tache(Tache $tache, Request $request, TacheRepository $tacheRepository, HistoriqueConnexionRepository $historiqueConnexionRepository)
    {
        if ($this->isCsrfTokenValid('prendre_tache' . $tache->getId(), $request->request->get('_token'))) {
            date_default_timezone_set('Europe/Paris');
            $user = $this->getUser();
            //Gestion des 8 heures de travail
            //28799 secondes = 8 heures
            if ($historiqueConnexionRepository->getEmployeNombreHeureTravailJournee($user)['ecart_seconde'] > 28799) {
                $this->addFlash("danger", "Vous avez travaillé plus de 8 heures aujourd'hui, vous ne pouvez plus prendre de tâches.");
            } else {
                //On vérifie qu'une tache n'est pas en cours
                $tacheActuelle = $tacheRepository->getTacheActuelle($user);
                if ($tacheActuelle) {
                    $tacheActuelle->setEtat(2);
                    $this->addFlash("warning", 'La tâche : "' . $tacheActuelle->getLibelle() . '" était en cours, elle est désormais considérée comme finie.');
                }
                $em = $this->getDoctrine()->getManager();
                $liaisonTache = new LiaisonTacheUser();
                $liaisonTache->setUser($user)
                    ->setTache($tache)
                    ->setHeurePrise(new \DateTime());
                $tache->setEtat(1);
                $em->persist($liaisonTache);
                $em->flush();
                $this->addFlash("success", "Vous avez pris la tâche " . $tache->getLibelle() . ".");
            }
        } else {
            $this->addFlash("danger", "Erreur lors de la prise de la tâche " . $tache->getLibelle() . ".");
        }
        return $this->redirectToRoute('employe');
    }

    /**
     * Permet à un employé de finir une tache
     * @Route("/employe/finir_tache/{tache}", name="employe_finir_tache", methods={"POST"})
     */
    public function finir_tache(Tache $tache, Request $request, TacheRepository $tacheRepository)
    {
        if ($this->isCsrfTokenValid('finir_tache' . $tache->getId(), $request->request->get('_token'))) {
            $user = $this->getUser();
            //On vérifie qu'une tache n'est pas en cours
            $tacheActuelle = $tacheRepository->getTacheActuelle($user);
            if ($tacheActuelle) {
                $tacheActuelle->setEtat(2);
                $this->addFlash("warning", 'La tâche : "' . $tacheActuelle->getLibelle() . '" est finie.');
            }
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        } else {
            $this->addFlash("danger", "Erreur lors de la finition de la tâche " . $tache->getLibelle() . ".");
        }
        return $this->redirectToRoute('employe');
    }
}
