<?php


namespace App\Controller;

use App\Entity\UserClient;
use App\Form\UserClientType;
use App\Entity\ServiceProvider;
use App\Form\ServiceProviderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class RegistrationController extends AbstractController
{
    #[Route('/register/service-provider', name: 'register_service_provider')]
    public function registerServiceProvider(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $serviceProvider = new ServiceProvider();
        $form = $this->createForm(ServiceProviderType::class, $serviceProvider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $serviceProvider->setPassword($passwordHasher->hashPassword($serviceProvider, $plainPassword));
            $entityManager->persist($serviceProvider);
            $entityManager->flush();
            $this->addFlash('success', 'Inscription du prestataire réussie !');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/registerProvider.html.twig', [
            'registrationForm' => $form->createView(),
            'type' => 'service_provider',
        ]);
    }

    #[Route('/register/user-client', name: 'register_user_client')]
    public function registerUserClient(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $userClient = new UserClient();
        $form = $this->createForm(UserClientType::class, $userClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $userClient->setPassword($passwordHasher->hashPassword($userClient, $plainPassword));
            $entityManager->persist($userClient);
            $entityManager->flush();
            $this->addFlash('success', 'Inscription du client réussie !');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/registerUser.html.twig', [
            'registrationForm' => $form->createView(),
            'type' => 'user_client',
        ]);
    }
}