<?php

namespace App\Controller;

use App\Repository\ServiceProviderRepository;
use App\Repository\UserClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ServiceProviderRepository $serviceProviderRepository, UserClientRepository $userClientRepository): Response
    {
        $services = $serviceProviderRepository->findAll();
        $clients = $userClientRepository->findAll();

        $servicesOffered = array_unique(array_filter(array_map(function($sp) {
            return $sp->getServiceOffered();
        }, $services)));
        sort($servicesOffered);
        return $this->render('home/index.html.twig', [
            'services' => $services,
            'clients' => $clients,
            'servicesOffered' => $servicesOffered
        ]);
    }



     #[Route('/showProvider', name: 'app_show_provider')]
    public function showProvider(ServiceProviderRepository $serviceProviderRepository): Response
    {
        return $this->render('home/showProviders.html.twig', [
            'service_providers' => $serviceProviderRepository->findAll(),
        ]);
    }


    
        #[Route('/showClients', name: 'app_show_clients')]
        public function showClients(UserClientRepository $userClientRepository): Response
        {
            return $this->render('home/showClients.html.twig', [
                'user_clients' => $userClientRepository->findAll(),
            ]);
        }

}
