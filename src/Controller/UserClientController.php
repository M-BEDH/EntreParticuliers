<?php

namespace App\Controller;

use App\Entity\UserClient;
use App\Form\UserClientType;
use App\Repository\UserClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user/client')]
final class UserClientController extends AbstractController
{
    #[Route(name: 'app_user_client_index', methods: ['GET'])]
    public function index(UserClientRepository $userClientRepository): Response
    {
        return $this->render('user_client/index.html.twig', [
            'user_clients' => $userClientRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userClient = new UserClient();
        $form = $this->createForm(UserClientType::class, $userClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($userClient);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_client/new.html.twig', [
            'user_client' => $userClient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_client_show', methods: ['GET'])]
    public function show(UserClient $userClient): Response
    {
        return $this->render('user_client/show.html.twig', [
            'user_client' => $userClient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserClient $userClient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserClientType::class, $userClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_client/edit.html.twig', [
            'user_client' => $userClient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_client_delete', methods: ['POST'])]
    public function delete(Request $request, UserClient $userClient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userClient->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($userClient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_client_index', [], Response::HTTP_SEE_OTHER);
    }
}
