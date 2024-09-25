<?php

namespace App\Controller\Admin;

use App\Entity\SectionTypeWebsitePage;
use App\Repository\SectionTypeWebsitePageRepository;
use App\Service\SlugService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/admin')]
class SectionTypeController extends AbstractController
{
    private $slugService;

    public function __construct(SlugService $slugService)
    {
        $this->slugService=$slugService;
    }
    #[Route('/sectiontype',methods:['GET'])]
    // Récupération de la liste des configurations des différentes pages web qui utilise la solution
    public function index(SectionTypeWebsitePageRepository $sectionTypeWebsitePageRepository,SerializerInterface $serializer){
        $allClient= $sectionTypeWebsitePageRepository->findAll();
        $data = $serializer->serialize($allClient, 'json', [
            'groups' => ['viewAdmin']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }

    #[Route('/sectiontype',methods:['POST'])]
    // Ajouter une nouvelles configuration de page ou section dans tous les sites
    function addWebsiteConfigType(EntityManagerInterface $entityManagerInterface,Request $request) : JsonResponse {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $slug=$this->slugService->clean_string($data["nom"]);
        $SectionTypeWebsitePage = new SectionTypeWebsitePage();
        $SectionTypeWebsitePage->setNom($data["nom"])
                               ->setSlug($slug)
                               ->setDescription($data["detail"]);
        $entityManagerInterface->persist($SectionTypeWebsitePage);
        $entityManagerInterface->flush();
        return new JsonResponse(['message' => "Configuration ajouter avec succées"], Response::HTTP_OK);
    }
}
