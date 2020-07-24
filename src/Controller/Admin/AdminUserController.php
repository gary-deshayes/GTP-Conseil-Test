<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Search\UserSearch;
use App\Repository\UserRepository;
use App\Form\Search\UserSearchType;
use Symfony\Component\Form\FormError;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/utilisateurs")
 */
class AdminUserController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    /**
     * Liste des utilisateurs
     * @Route("/", name="admin_user_index", methods={"GET","POST"})
     */
    public function index(UserRepository $userRepository, Request $request, PaginatorInterface $paginator ): Response
    {
        $userSearch = new UserSearch();
        $formSearch = $this->createForm(UserSearchType::class, $userSearch);
        $formSearch->handleRequest($request);
        $users = $paginator->paginate(
            $userRepository->searchUser($userSearch),
            $request->query->getInt('page',1),
            10
        );
        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
            'formSearch' => $formSearch->createView(),
            
        ]);
    }

    /**
     * Ajout d'un utilisateur
     * @Route("/nouveau", name="admin_user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $data = $request->get("user");
        if ($form->isSubmitted() && $form->isValid()) {
            //Permet de gérer le fait que si on laisse le mot de passe vide sous symfony, le mot de passe s'écrase
            if ($data["password_clear"] === "") {
                $form->addError(new FormError('Veuillez saisir un mot de passe'));
            } else {
                $user->setPassword($this->passwordEncoder->encodePassword($user, $data["password_clear"]));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', "Le membre avec l'email " . $user->getEmail() . " a été créée.");

                return $this->redirectToRoute('admin_user_index');
            }
        }

        return $this->render('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Modification d'un utilisateur
     * @Route("/{id}/modification", name="admin_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Permet de gérer le fait que si on laisse le mot de passe vide sous symfony, le mot de passe s'écrase
            if (!empty($user->getPasswordClear())) {
                $passclear = $user->getPasswordClear();
                $user->setPassword($this->passwordEncoder->encodePassword($user, $passclear));
            }
            $this->addFlash('success', "Le membre avec l'email " . $user->getEmail() . " a été modifié.");

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Suppression d'un utilisateur
     * @Route("/{id}", name="admin_user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('danger', "Le membre avec l'email " . $user->getEmail() . " a été supprimé.");

        }

        return $this->redirectToRoute('admin_user_index');
    }
}
