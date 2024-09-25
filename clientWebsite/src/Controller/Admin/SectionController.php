<?php

namespace App\Controller\Admin;

use App\Entity\Section;
use App\Repository\ClientRepository;
use App\Repository\ClientSectionRepository;
use App\Repository\SectionRepository;
use App\Repository\SectionTypeWebsitePageRepository;
use App\Repository\SiteRepository;
use App\Repository\SiteSectionRepository;
use App\Service\GalerieService;
use App\Service\SlugService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;


class SectionController extends AbstractController
{
    protected string $domaineMedia ="http://localhost:8001/images/";
    protected $baseUrl;
    private $galerieService;
    private $slugService;
    public function __construct(RequestStack $requestStack,GalerieService $galerieService,SlugService $slugService)
    {
        $this->baseUrl = $requestStack->getCurrentRequest()->getSchemeAndHttpHost();
        $this->domaineMedia=$this->baseUrl."/"."images/";
        $this->galerieService=$galerieService;
        $this->slugService=$slugService;

    }
    #[Route('/section/type/{id}', name: 'app_section_get',methods:['GET'])]
    public function allSectionWhereType(int $id,SectionRepository $sectionRepository,SerializerInterface $serializer): Response
    {
        $sections = $sectionRepository->findBy(['sectionType'=>$id]);
        $data = $serializer->serialize($sections, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
       
    }
    #[Route('/sectionall', name: 'app_section_getall',methods:['GET'])]
    public function allSection(SectionRepository $sectionRepository,SerializerInterface $serializer): Response
    {
        $sections = $sectionRepository->findAll();
        $data = $serializer->serialize($sections, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
       
    }
    #[Route('/section', name: 'app_section_add',methods:['POST'])]
    public function addNewSection(Request $request,EntityManagerInterface $entityManagerInterface,SectionTypeWebsitePageRepository $sectionTypeWebsitePageRepository,SectionRepository $sectionRepository): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $requestFile=$request->files->all();
        $sectionType=$sectionTypeWebsitePageRepository->find($data["idSectionType"]);
        // $tabJs=[];
        // if ($data["js"]!="") {
        //     // split string
        //     $tabJs=explode("|", $data["js"]);
        // }
        $imgPreview="";
        if ($requestFile) {
            $sfile = $requestFile["logo"];
            $imgPreview=$this->domaineMedia."modules". '/';
            $imgPreview=$imgPreview.$this->galerieService->saveimage($sfile,"modules");  
        }
        // Récupérer l'index basé sur le nombre de sections existantes pour ce sectionType
        $sectionCount = $sectionRepository->count(['sectionType' => $sectionType]);
        $index = str_pad($sectionCount + 1, 2, '0', STR_PAD_LEFT);  // Index à deux chiffres
        $slugName = $sectionType->getSlug();
        $sectionName = "{$slugName}{$index}";
        $twigDir = "components/$slugName/$sectionName.html.twig";
        //"components/{$slugName}";
        $cssDir = "assets/css/$slugName/$sectionName.css";
        //"public/assets/css/{$slugName}";
        $jsDir = "assets/js/$slugName/$sectionName.js";
        //"public/assets/js/{$slugName}";
        // Génération des fichiers
        $this->generateFiles($slugName, $sectionName, $sectionType->getNom());
        $slug=$this->slugService->clean_string($data["sectionName"]);

        $section = new Section();
        $section->setName($data["sectionName"])
                ->setType($data["type"])
                ->setSectionType($sectionType)
                ->setContent($data["defaultValue"])
                ->setCss($cssDir)
                ->setPath($twigDir)
                ->setJs($jsDir)
                ->setImage($imgPreview)
                ->setUrlPreview($slug);
        $entityManagerInterface->persist($section);
        $entityManagerInterface->flush();
        
        return new JsonResponse(['message' => "Section créé avec succès."], Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/section/detail/{id}', name: 'app_section_detail',methods:['GET'])]
    public function detailSection(int $id,SectionRepository $sectionRepository,SerializerInterface $serializer): Response
    {
        $sections = $sectionRepository->find($id);
        $data = $serializer->serialize($sections, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
       
    }
    #[Route('/section/client/{id}', name: 'app_section_assign_client_list',methods:['GET'])]
    public function clientSectionAsigned(int $id,SerializerInterface $serializer,ClientRepository $clientRepository,ClientSectionRepository $clientSectionRepository,SiteRepository $siteRepository): Response
    {
        $client = $clientRepository->find($id);
        if (!$client) {
            throw $this->createNotFoundException("Client introuvable. $id");
        }
        // récupération de tous les sites du clients
        $sections = $clientSectionRepository->findBy(['client' => $client]);
        $data = $serializer->serialize($sections, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    private function generateFiles(string $slugName, string $sectionName, string $sectionTypeName)
    {
        // Chemins des répertoires
        $twigDir =$this->getParameter('twig'). "/{$slugName}";
        $cssDir =$this->getParameter('css'). "/{$slugName}";
        $jsDir =$this->getParameter('js'). "/{$slugName}";
        // Créer les répertoires s'ils n'existent pas
        if (!is_dir($twigDir)) {
            mkdir($twigDir, 0777, true);
        }
        if (!is_dir($cssDir)) {
            mkdir($cssDir, 0777, true);
        }
        if (!is_dir($jsDir)) {
            mkdir($jsDir, 0777, true);
        }

        // Création du fichier Twig
        $twigPath = "{$twigDir}/{$sectionName}.html.twig";
        $twigContent = "<h1>{$sectionName} - {$sectionTypeName}</h1>";
        file_put_contents($twigPath, $twigContent);

        // Création du fichier CSS
        $cssPath = "{$cssDir}/{$sectionName}.css";
        $cssContent = "/* Styles for {$sectionName} */";
        file_put_contents($cssPath, $cssContent);

        // Création du fichier JS
        $jsPath = "{$jsDir}/{$sectionName}.js";
        $jsContent = "// JavaScript for {$sectionName}";
        file_put_contents($jsPath, $jsContent);
        
    }
}
