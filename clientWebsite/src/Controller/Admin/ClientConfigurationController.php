<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Entity\ConfigEntreprise;
use App\Entity\SocialMediaLink;
use App\Entity\User;
use App\Entity\Utilisateur;
use App\Entity\VariationProduct;
use App\Repository\ClientRepository;
use App\Repository\ConfigEntrepriseRepository;
use App\Service\GalerieService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/admin')]
class ClientConfigurationController extends AbstractController
{
    protected string $domaineMedia ="http://localhost:8001/images/";
    protected $baseUrl;
    private $galerieService;

    public function __construct(RequestStack $requestStack,GalerieService $galerieService)
    {
        $this->baseUrl = $requestStack->getCurrentRequest()->getSchemeAndHttpHost();
        $this->domaineMedia=$this->baseUrl."/"."images/";
        $this->galerieService=$galerieService;
    }
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
    #[Route('/client-configuration', name: 'app_client_configuration_findall',methods:['GET'])]
    public function getAllClient(ClientRepository $clientRepository,SerializerInterface $serializer): Response
    {
        $clients = $clientRepository->findAll();
        $data = $serializer->serialize($clients, 'json', [
            'groups' => ['viewAdmin']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/client-configuration', name: 'app_client_configuration_post',methods:['POST'])]
    public function saveOneClient(Request $request,UserPasswordHasherInterface $encoder,EntityManagerInterface $entityManagerInterface): JsonResponse
    {
        // Fin de récupération des informations de l'utilisateur et de l'entreprise
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $requestFile=$request->files->all();
        $logo="";
        if ($requestFile) {
            $sfile = $requestFile["logo"];
            $logo=$this->domaineMedia.$data["nomEntreprise"]. '/';
            $logo=$logo.$this->galerieService->saveimage($sfile,$data["nomEntreprise"]);  
        }
        $client = new Client();
        $client->setLogo($logo)
                ->setNomEntreprise($data["nomEntreprise"])
                ->setDescription($data["description"])
                ->setTelephoneRepresentant($data["telephoneRepresentant"])
                ->setEmailEntreprise($data["emailEntreprise"])
                ->setAdresse($data["adresse"])
                ->setWebsiteType($data["websiteType"])
                ->setGalerieSizeActuel(0)
                ->setGalerieSizeLimit($data["galerieSizeLimit"])
                ->setDateDebutAbonnement(new DateTimeImmutable($data["dateDebutAbonnement"]))
                ->setDateFinAbonnement(new DateTimeImmutable($data["dateFinAbonnement"]))
                ->setDomain($data["linkWebsite"]);
        $entityManagerInterface->persist($client);
        $utilisateur = new Utilisateur();
        $utilisateur->setPrenom($data["prenom"])
                    ->setNom($data["nom"])
                    ->setTelephone($data["telephone"])
                    ->setEmail($data["email"])
                    ->setClient($client);
        $entityManagerInterface->persist($utilisateur);
        $user = new User();
        $password=$encoder->hashPassword($user,"welcome");
        $user->setUsername($data["username"])
            ->setPassword($password)
            ->setRoles(["ROLE_CLIENT_ADMIN"])
            ->setUtilisateur($utilisateur);
        $entityManagerInterface->persist($user);
        $socialMedia= new SocialMediaLink();
        $socialMedia->setNumero($client->getTelephoneRepresentant())
                    ->setHomemessage("Bonjour *".$client->getNomEntreprise()."* je viens de visiter votre site web et je serais intéresser par :")
                    ->setShopmessage("Bonjour *".$client->getNomEntreprise()."* je viens de visiter votre site web et je serais intéresser par le produit suivant:")
                    ->setFacebook("https://facebook.com/")
                    ->setInstagram("https://instagram.com/")
                    ->setClient($client)
                    ->setSnapchat("https://snapchat.com/");
        $entityManagerInterface->persist($socialMedia);
        $tabsVariation=[
            ["nom"=>"Taille","valeur"=>[]],
            ["nom"=>"Poids","valeur"=>[]],
        ];
        for ($i=0; $i <count($tabsVariation) ; $i++) { 
            $configVariationProduct = new VariationProduct();
            $configVariationProduct->setNom($tabsVariation[$i]["nom"])
                                ->setValeur($tabsVariation[$i]["valeur"])
                                ->setClient($client);
            $entityManagerInterface->persist($configVariationProduct);
        }
        // Création des page par defaut des site du client
        $tabPage=["Accueil","Boutique","Contact"];
        $entityManagerInterface->flush();
        // Connection à l'API 
        return new JsonResponse(['message' => "Configuration client effectuer avec succées"], Response::HTTP_CREATED, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/client-configuration/{id}', name: 'app_client_configuration_detail',methods:['GET'])]
    public function getInfosOneClient(): Response
    {
        return $this->render('client_configuration/index.html.twig', [
            'controller_name' => 'ClientConfigurationController',
        ]);
    }

    // public function saveimage($file,$name){
    //     $fileName = md5(uniqid()) . '.' . $file->guessExtension();
    //     $file->move($this->getParameter('chemin').'/'.$name, $fileName);
    //     return $fileName;
    // }
}
