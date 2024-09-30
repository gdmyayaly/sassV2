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
use DOMDocument;
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
        $tabCSS=[];
        $tabJS=[];
          // Récupérer les fichiers CSS et JS depuis la requête
        $cssFiles = $request->files->get('cssFiles');
        $jsFiles = $request->files->get('jsFiles');
        if ($cssFiles) {}
        $cssDir =$this->getParameter('css'). "/{$slugName}";
        $jsDir =$this->getParameter('js'). "/{$slugName}";
        // $cssPath = "{$cssDir}/{$sectionName}.css";
        // $jsPath = "{$cssDir}/{$sectionName}.css";
        // Tableau pour les erreurs
        $errors = [];
        if ($cssFiles) {
            foreach ($cssFiles as $file) {
                if ($file->getMimeType() === 'text/css') {
                    $originalFilename = $file->getClientOriginalName();
                    try {
                        // Sauvegarde du fichier avec son nom d'origine
                        $file->move($cssDir, $originalFilename);
                        array_push($tabCSS, "{$cssDir}/{$originalFilename}");

                    } catch (\Exception $e) {
                        $errors[] = 'Erreur lors de la sauvegarde du fichier CSS : ' . $file->getClientOriginalName();
                    }
                } else {
                    $errors[] = 'Le fichier CSS ' . $file->getClientOriginalName() . ' n\'est pas valide.';
                }
            }
        }
        if ($jsFiles) {
            foreach ($jsFiles as $file) {
                if ($file->getMimeType() === 'application/javascript') {
                    $originalFilename = $file->getClientOriginalName();
                    try {
                        // Sauvegarde du fichier avec son nom d'origine
                        $file->move($jsDir, $originalFilename);
                        array_push($tabJS, "{$jsDir}/{$originalFilename}");
                    } catch (\Exception $e) {
                        $errors[] = 'Erreur lors de la sauvegarde du fichier JS : ' . $file->getClientOriginalName();
                    }
                } else {
                    $errors[] = 'Le fichier JS ' . $file->getClientOriginalName() . ' n\'est pas valide.';
                }
            }
        }
        //"components/{$slugName}";
        $cssDir = "assets/css/$slugName/$sectionName.css";
        //"public/assets/css/{$slugName}";
        $jsDir = "assets/js/$slugName/$sectionName.js";
        array_push($tabCSS,$cssDir);
        array_push($tabJS,$jsDir);
        // Génération des fichiers
        $jsonContent=$this->generateFiles($slugName, $sectionName, $sectionType->getNom(),$data["html"],$data["css"],$data["js"]);
        $slug=$this->slugService->clean_string($data["sectionName"]);
        $section = new Section();
        $section->setName($data["sectionName"])
                ->setType($data["type"])
                ->setSectionType($sectionType)
                ->setContent($jsonContent)
                ->setCss($tabCSS)
                ->setPath($twigDir)
                ->setDemoUrl($this->baseUrl."/section/demo/$slug")
                ->setJs($tabJS)
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
    #[Route('/section/demo/{slug}', name: 'app_section_demo',methods:['GET'])]
    public function demoPreviewSection(string $slug,SectionRepository $sectionRepository,SerializerInterface $serializer): Response
    {
        $section = $sectionRepository->findOneBy(['urlPreview'=>$slug]);
        return $this->render('website/demo.html.twig', [
            'section' => $section,
        ]);
    }
    public function extractAndGenerate($htmlContent)
    {
        // Charger le contenu HTML
        $dom = new DOMDocument();
        @$dom->loadHTML($htmlContent);

        $phpContent = "";
        $jsonData = [
            'content' => [
                'text' => [],
                'images' => [],
                'links' => []
            ],
            'styles' => []
        ];

        $elementCounter = 0; // Compteur pour les éléments

        // Fonction récursive pour parcourir tous les éléments enfants et extraire le contenu et les styles
        $processNode = function ($node) use (&$jsonData, &$phpContent, &$elementCounter, &$processNode) {
            global $dom;

            // Ignorer les noeuds de texte vides
            if ($node->nodeType === XML_TEXT_NODE) {
                $textContent = trim($node->textContent);
                if ($textContent === '') {
                    return;
                }

                // Créer une clé unique pour le texte
                $textKey = "text_$elementCounter";
                $elementCounter++;

                // Ajouter le contenu textuel au JSON
                $jsonData['content']['text'][$textKey] = addslashes($textContent);

                // Ajouter le texte au fichier PHP avec la variable Twig
                // $phpContent .= "{{ section.content.text['$textKey'] }}\n";
                $phpContent .= "{{ section.content.text.$textKey }}\n";

                return;
            }

            $tagName = strtolower($node->tagName);
            $attributes = "";

            // Gérer les attributs de l'élément (classes, id, etc.)
            foreach ($node->attributes as $attr) {
                if ($attr->name === 'style') {
                    // Extraire les styles
                    $styles = $this->parseStyles($attr->value);
                    if (!empty($styles)) {
                        $styleKey = "style_$elementCounter";
                        $jsonData['styles'][$styleKey] = $styles;
                        $attributes .= ' style="';
                        foreach ($styles as $prop => $val) {
                            $attributes .= "$prop: {{ section.styles['$styleKey']['$prop'] }}; ";
                        }
                        $attributes .= '"';
                    }
                } elseif ($tagName === 'img' && $attr->name === 'src') {
                    // Gérer les images
                    $imgKey = "image_$elementCounter";
                    $jsonData['content']['images'][$imgKey] = $node->getAttribute('src');
                    // $attributes .= " src=\"{{ section.content.images['$imgKey'] }}\"";
                    $attributes .= " src=\"{{ section.content.images.$imgKey }}\"";
                } elseif ($tagName === 'a' && $attr->name === 'href') {
                    // Gérer les liens
                    $linkKey = "link_$elementCounter";
                    $jsonData['content']['links'][$linkKey] = $node->getAttribute('href');
                    // $attributes .= " href=\"{{ section.content.links['$linkKey'] }}\"";
                    $attributes .= " href=\"{{ section.content.links.$linkKey }}\"";
                } else {
                    // Ajouter les autres attributs tels quels
                    $attributes .= " {$attr->name}=\"{$attr->value}\"";
                }
            }

            // Ouvrir la balise dans le fichier PHP
            $phpContent .= "<$tagName$attributes>";

            // Parcourir les enfants du noeud
            foreach ($node->childNodes as $childNode) {
                $processNode($childNode);
            }

            // Fermer la balise
            $phpContent .= "</$tagName>\n";
        };

        // Traiter chaque élément sous le body
        foreach ($dom->getElementsByTagName('body')->item(0)->childNodes as $node) {
            $processNode($node);
        }

        // // Écrire le contenu PHP généré dans le fichier de sortie
        // file_put_contents($twigOutputPath, $phpContent);

        // // Retourner le JSON minimisé
        // return json_encode($jsonData);
        return [$phpContent,json_encode($jsonData)];
    }

    // Fonction pour parser les styles en tableau
    private function parseStyles($styleString)
    {
        $styles = [];
        $styleArray = explode(';', $styleString);
        foreach ($styleArray as $style) {
            $style = trim($style);
            if (!empty($style)) {
                list($property, $value) = explode(':', $style);
                $styles[trim(str_replace('-', '_', $property))] = trim($value);
            }
        }
        return $styles;
    }

    private function generateFiles(string $slugName, string $sectionName, string $sectionTypeName, string $html,string $cssContent,string $jsContent)
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
        $twigContent = $this->extractAndGenerate($html)[0];
        //= "<h1>{$sectionName} - {$sectionTypeName}</h1>";
        file_put_contents($twigPath, $twigContent);

        // Création du fichier CSS
        $cssPath = "{$cssDir}/{$sectionName}.css";
        file_put_contents($cssPath, $cssContent);

        // Création du fichier JS
        $jsPath = "{$jsDir}/{$sectionName}.js";
        file_put_contents($jsPath, $jsContent);
        return $this->extractAndGenerate($html)[1];
    }
}
