<?php

namespace App\Controller\Admin;

use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\TacheRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/admin/tache")
 */
class AdminTacheController extends AbstractController
{
    /**
     * Liste des tâches
     * @Route("/", name="admin_tache_index", methods={"GET","POST"})
     */
    public function index(TacheRepository $tacheRepository): Response
    {
        return $this->render('admin/tache/index.html.twig', [
            'taches' => $tacheRepository->findBy([], ['heureDebut' => "ASC"]),
        ]);
    }

    /**
     * Ajout d'une tâche
     * @Route("/nouvelle", name="admin_tache_new", methods={"GET","POST"})
     */
    public function new(Request $request, ValidatorInterface $validator): Response
    {
        $tache = new Tache();
        $form = $this->createForm(TacheType::class, $tache);
        // Règle le problème du validator GreaterThan entre les heures
        if ($request->getMethod() == "POST") {
            //On gère les heures qui ne sont pas converties par le handleRequest
            $data = $request->request->get('tache');
            $tache->setHeureDebut(new DateTime($data["heure_debut"]));
            $tache->setHeureFin(new DateTime($data["heure_fin"]));
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //On gère les heures qui ne sont pas converties par le handleRequest

            $tache->setEtat(false);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tache);
            $entityManager->flush();
            $this->addFlash('success', "La tâche " . $tache->getLibelle() . " a été ajoutée.");
            return $this->redirectToRoute('admin_tache_index');
        }

        return $this->render('admin/tache/new.html.twig', [
            'tache' => $tache,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Modification d'une tâche
     * @Route("/{id}/modification", name="admin_tache_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tache $tache): Response
    {
        $form = $this->createForm(TacheType::class, $tache);
        // Règle le problème du validator GreaterThan entre les heures
        if ($request->getMethod() == "POST") {
            //On gère les heures qui ne sont pas converties par le handleRequest
            $data = $request->request->get('tache');
            $tache->setHeureDebut(new DateTime($data["heure_debut"]));
            $tache->setHeureFin(new DateTime($data["heure_fin"]));
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "La tâche " . $tache->getLibelle() . " a été modifiée.");

            return $this->redirectToRoute('admin_tache_index');
        }

        return $this->render('admin/tache/edit.html.twig', [
            'tache' => $tache,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Suppression d'une tâche
     * @Route("/{id}", name="admin_tache_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tache $tache): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tache->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tache);
            $entityManager->flush();
            $this->addFlash('danger', "La tâche " . $tache->getLibelle() . " a été supprimée.");
        }

        return $this->redirectToRoute('admin_tache_index');
    }
}
