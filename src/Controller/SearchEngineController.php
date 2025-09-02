<?php

namespace App\Controller;

use App\Repository\UserClientRepository;
use App\Repository\ServiceProviderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


final class SearchEngineController extends AbstractController
{

    #[Route('/search/engine/offered', name: 'app_search_engine_offered', methods: ['GET','POST'])]
    public function serviceOffered(Request $request, UserClientRepository $clientRepo ): Response
    {
          if ($request->isMethod('GET')){
            //recupere les données de la requete
            $data = $request->query->all();
            //recupere le mot-cle de la recherche
            $word = $data['word'];
            
            //appelle la method searchEngine du repo productRepository
            //   $servicesRequested = $clientRepo->searchEngine($word);
              $servicesOffered = $clientRepo->searchEngine($word);
          }

        // if ($servicesRequested == []) {
        //     $this->addFlash('warning', 'Cette demande de service n\'existe pas !');
        //       return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        // }

        if ($servicesOffered == []) {  
            $this->addFlash('warning', 'Cette offre de service n\'existe pas !');
              return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('search_engine/index.html.twig', [
            'word' => $word,
            // 'servicesRequested' => $servicesRequested,
            'service' => $servicesOffered,
        ]);
    }


     #[Route('/search/engine/requested', name: 'app_search_engine_requested', methods: ['GET','POST'])]
    public function serviceRequested(Request $request, ServiceProviderRepository $serviceRepo): Response
    {
          if ($request->isMethod('GET')){
            //recupere les données de la requete
            $data = $request->query->all();
            //recupere le mot-cle de la recherche
            $word = $data['word'];
            
            //appelle la method searchEngine du repo productRepository
            $servicesRequested = $serviceRepo->searchEngine($word);
            //   $servicesOffered = $serviceRepo->searchEngine($word);
          }

        if ($servicesRequested == []) {
            $this->addFlash('warning', 'Cette demande de service n\'existe pas !');
              return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        // elseif ($servicesOffered == []) {  
        //     $this->addFlash('warning', 'Cette offre de service n\'existe pas !');
        //       return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        // }

        return $this->render('search_engine/index.html.twig', [
            'word' => $word,
            'services' => $servicesRequested,
            // 'servicesOffered' => $servicesOffered,
        ]);
    }

} 
