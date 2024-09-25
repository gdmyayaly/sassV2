<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\SectionRepository;
use App\Service\DomainService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SiteController extends AbstractController
{
    private $domainService;
    private $clientRepository;
    private $sectionRepository;

    public function __construct(
        DomainService $domainService,
        ClientRepository $clientRepository,
        SectionRepository $sectionRepository
    ) {
        $this->domainService = $domainService;
        $this->clientRepository = $clientRepository;
        $this->sectionRepository = $sectionRepository;
    }

    #[Route('/site/{domain}', name: 'app_site',methods:['GET'])]
    public function index(string $domain): Response
    {
        $client = $this->domainService->getClientByDomain($domain);

        if (!$client) {
            throw $this->createNotFoundException('Client introuvable.');
        }

        $sections = $this->sectionRepository->findBy(['client' => $client]);

        return $this->render('site/layout.html.twig', [
            'client' => $client,
            'sections' => $sections,
        ]);
    }
}
