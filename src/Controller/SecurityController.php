<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\UserClientRepository;
use App\Repository\ServiceProviderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function manualLogin(
        Request $request,
        UserClientRepository $userClientRepo,
        ServiceProviderRepository $serviceProviderRepo,
        UserPasswordHasherInterface $passwordHasher,
    TokenStorageInterface $tokenStorage
    ): Response {
        $error = null;
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('_password');

            $user = $userClientRepo->findOneBy(['email' => $email]) ?? $serviceProviderRepo->findOneBy(['email' => $email]);

            if ($user && $passwordHasher->isPasswordValid($user, $password)) {
                $token = new UsernamePasswordToken($user, 'main', $user->getRoles());
                $tokenStorage->setToken($token);
                if (in_array('ROLE_CLIENT', $user->getRoles())) {
                    return new RedirectResponse($this->generateUrl('app_show_provider'));
                }
                if (in_array('ROLE_PROVIDER', $user->getRoles())) {
                    return new RedirectResponse($this->generateUrl('app_show_clients'));
                }
                return new RedirectResponse($this->generateUrl('app_home'));
            } else {
                $error = 'Identifiants invalides';
            }
        }
        return $this->render('security/login.html.twig', [
            'error' => $error,
            'email' => $email ?? '',
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - il sera intercepté par le firewall.');
    }
}
