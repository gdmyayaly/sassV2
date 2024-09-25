<?php

namespace App\Controller;

use App\Entity\ClientSection;
use App\Repository\ClientRepository;
use App\Repository\SectionRepository;
use App\Service\DomainService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AdminController extends AbstractController
{
    private $clientRepository;
    private $sectionRepository;
    private $domainService;
    private $em;

    public function __construct(
        ClientRepository $clientRepository,
        SectionRepository $sectionRepository,
        DomainService $domainService,
        EntityManagerInterface $em
    ) {
        $this->clientRepository = $clientRepository;
        $this->sectionRepository = $sectionRepository;
        $this->domainService = $domainService;
        $this->em = $em;
    }
    #[Route('/admin', name: 'app_admin')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AdminController.php',
        ]);
    }
    #[Route('/api/admin/client/{id}/assign-domain', name: 'app_admin_assign-domain',methods:['POST'])]
    public function assignDomain(int $id,Request $request): JsonResponse
    {
        $client = $this->clientRepository->find($id);
        $data = json_decode($request->getContent(), true);
        $domain = $data['domain'];
        try {
            $this->domainService->assignDomain($client, $domain);
            return $this->json(['message' => 'Domaine assigné avec succès.']);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }
    #[Route('/api/admin/client/{id}/assign-sections/{sectionIds}', name: 'app_admin_assign-sections',methods:['GET'])]
    public function assignSections(int $id,int $sectionIds): JsonResponse
    {
        $client = $this->clientRepository->find($id);
        $section = $this->sectionRepository->find(['id' => $sectionIds]);
        $clientSection = new ClientSection();
        $clientSection->setClient($client)
                      ->setSection($section);
        $this->em->persist($clientSection);
        $this->em->flush();

        return $this->json(['message' => 'Section assignée avec succès.']);
    }
    

}
