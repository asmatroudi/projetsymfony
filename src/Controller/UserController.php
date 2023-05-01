<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Form\ProfileType;


class UserController extends AbstractController
{
    #[Route('admin/user/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('user/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('admin/user/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(Utilisateur $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('user/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Utilisateur $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('admin/user/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getIduser(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('admin/user/{id}/block', name: 'app_user_block', methods: ['GET', 'POST'])]
    public function block(Utilisateur $user, Request $request): Response
    {
            $user->setIsBlocked(!$user->isBlocked());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            if($user->isBlocked()) {
                $this->addFlash('success', 'User blocked.');
            } else {
                $this->addFlash('success', 'User unblocked.');
            }

            return $this->redirectToRoute('app_user_index');

        return $this->render('user/block.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('user/{id}/editprofile', name: 'app_user_edit_profile', methods: ['GET', 'POST'])]
    public function editProfile(Request $request, Utilisateur $user, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        // $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            
            $userRepository->save($user, true);
            if($user->getRole() == "admin") {
                return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    
    #[Route('admin/user/{id}/deleteprofile', name: 'app_user_delete_profile', methods: ['POST'])]
    public function deleteAccount(Request $request, Utilisateur $user, UserRepository $userRepository, TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authChecker): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getIduser(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        $response = new Response();
        $response->setContent('Your account has been deleted successfully. You have been logged out.');
        
        if ($authChecker->isGranted('ROLE_USER')) {
            $tokenStorage->getToken()->setAuthenticated(false);
        }

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

}
