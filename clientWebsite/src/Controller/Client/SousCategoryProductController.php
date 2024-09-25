<?php

namespace App\Controller\Client;

use App\Entity\CategoryProduct;
use App\Entity\Client;
use App\Entity\Galerie;
use App\Entity\SousCategoryProduct;
use App\Entity\User;
use App\Repository\CategoryProductRepository;
use App\Repository\ClientRepository;
use App\Repository\SousCategoryProductRepository;
use App\Repository\UserRepository;
use App\Service\GalerieService;
use App\Service\SlugService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/client')]

class SousCategoryProductController extends AbstractController
{
    private $galerieService;
    private $slugService;

    public function __construct(GalerieService $galerieService,SlugService $slugService)
    {
        $this->galerieService=$galerieService;
        $this->slugService=$slugService;
    }

    #[Route('/souscategory/{id}',methods:['GET'])]
    function getAllSousCategory(Request $request,int $id,CategoryProductRepository $categoryProductRepository,SousCategoryProductRepository $sousCategoryProductRepository,UserRepository $userRepository,SerializerInterface $serializer,ClientRepository $clientRepository):Response{        
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $category= $categoryProductRepository->findOneBy(['client'=>$entreprise,'isDeleted'=>false,'id'=>$id]);
        if(!$category){
            return new JsonResponse(['message' => "Information indisponible"], Response::HTTP_BAD_REQUEST);  
        }
        $sousCat=$sousCategoryProductRepository->findBy(['category'=>$category]);
        $data = $serializer->serialize($sousCat, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/souscategory/add',methods:['POST'])]
    function addCategoryProduct(SerializerInterface $serializer,Request $request,CategoryProductRepository $categoryProductRepository,SousCategoryProductRepository $sousCategoryProductRepository,EntityManagerInterface $entityManagerInterface,UserRepository $userRepository,ClientRepository $clientRepository) : JsonResponse {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        
        $requestFile=$request->files->all();
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $category= $categoryProductRepository->findOneBy(['client'=>$entreprise,'isDeleted'=>false,'id'=>$data['id']]);
        if(!$category){
            return new JsonResponse(['message' => "Information indisponible"], Response::HTTP_BAD_REQUEST);  
        }
        $totalSize=$entreprise->getGalerieSizeActuel();
        $image="";
        // Vérification si il a choisi une image de la galerie ou in a fait un upload d'image
        if ($data["isUpload"]=="true") {
            $sfile = $requestFile["image"];
            $newName=$this->galerieService->saveImageGetDetail($sfile,$entreprise->getNomEntreprise()); 
            $totalSize=$totalSize+$newName["size"];
            $galerie = $this->galerieService->addNewGalerie($sfile,$newName,$entreprise);
            // if ($totalSize>=$entreprise->getGalerieSizeLimit()) {
            //     return new JsonResponse(['message' => "Image non enregistrer car vous avez atteint la limite de votre compte"], Response::HTTP_BAD_REQUEST);  
            // }
            // else{
                $entreprise->setGalerieSizeActuel($totalSize);
                $entityManagerInterface->persist($entreprise);
                $entityManagerInterface->persist($galerie);
                $image= $galerie->getDocumentUrl();
            //}
        }
        else{
            $image=$data["media"];
        }
        $slug=$this->slugService->clean_string($data["nom"]);
        // Vérifier si le slug n'existe pas 
        $verify=$sousCategoryProductRepository->findOneBy(['isDeleted'=>false,'slug'=>$slug,'category'=>$category]);
        if($verify){
            return new JsonResponse(['message' => "Sous Catégorie déjas existence veuillez changer de nom de votre sous catégorie ou supprimer celle deja existante"], Response::HTTP_BAD_REQUEST);  
        }
        $sousCategory = new SousCategoryProduct();
        $sousCategory->setNom($data["nom"])
                 ->setDescription($data["detail"])
                 ->setImage($image)
                 ->setCategory($category)
                 ->setCreteadAt(new DateTimeImmutable('now'))
                 ->setDeletedAt(new DateTimeImmutable('now'))
                 ->setIsDeleted(false)
                 ->setSlug($slug);
        $entityManagerInterface->persist($sousCategory);
        $entityManagerInterface->flush();
        return new JsonResponse(['message' => "Sous Catégorie enregistrer avec succés"], Response::HTTP_OK);  
    }
    #[Route('/souscategory/detail/{cat}/{id}',methods:['GET'])]
    function getOneCategory(EntityManagerInterface $entityManager,int $cat,int $id,SerializerInterface $serializer):Response{ 
        $user=$entityManager->getRepository(User::class)->find($this->getUser());
        $entreprise= $entityManager->getRepository(Client::class)->find($user->getUtilisateur()->getClient()->getId());
        $category= $entityManager->getRepository(CategoryProduct::class)->findOneBy(['client'=>$entreprise,'isDeleted'=>false,"id"=>$cat]);
        $sousCat=null;
        foreach ($category->getSousCategoryProducts() as $key => $value) {
            if ($value->getId()==$id) {
                $sousCat=$value;
            }
        }
        if ($sousCat==null || !$category) {
            return new JsonResponse(['message' => "Sous Catégorie non disponible"], Response::HTTP_BAD_REQUEST);  
        }

        $data = $serializer->serialize($sousCat, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/souscategory/remove',methods:['POST'])]
    function removeCategory(SerializerInterface $serializer,UserRepository $userRepository,ClientRepository $clientRepository,Request $request,EntityManagerInterface $entityManagerInterface,SousCategoryProductRepository $sousCategoryProductRepository) : JsonResponse {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $totalSize=$entreprise->getGalerieSizeActuel();
        $sousCategory= $sousCategoryProductRepository->find($data["id"]);
        if (!$sousCategory) {
            return new JsonResponse(['message' => "Sous Catégorie non disponible"], Response::HTTP_BAD_REQUEST);  
        }
        $sousCategory->setIsDeleted(true)
                     ->setOldCategory($sousCategory->getCategory()->getId())
                     ->setCategory(null)
                     ->setDeletedAt(new DateTimeImmutable('now'));
        $entityManagerInterface->persist($sousCategory);
        $entityManagerInterface->flush();
        return new JsonResponse(['message' => "Sous Catégorie supprimer avec succées"], Response::HTTP_OK);  
    }
    #[Route('/souscategory/update',methods:['POST'])]
    function updateCategoryProduct(SerializerInterface $serializer,Request $request,EntityManagerInterface $entityManagerInterface,UserRepository $userRepository,ClientRepository $clientRepository,CategoryProductRepository $categoryProductRepository,SousCategoryProductRepository $sousCategoryProductRepository) : JsonResponse {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $requestFile=$request->files->all();
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $totalSize=$entreprise->getGalerieSizeActuel();
        $image="";
        $category= $categoryProductRepository->findOneBy(["id"=>$data["idCat"],"client"=>$entreprise,'isDeleted'=>false]);
        $sousCategory= $sousCategoryProductRepository->findOneBy(["id"=>$data["idSousCat"],'isDeleted'=>false]);
        if (!$category || !$sousCategory) {
            return new JsonResponse(['message' => "Sous Catégorie non disponible"], Response::HTTP_BAD_REQUEST);  
        }
        // Vérification si il a choisi une image de la galerie ou in a fait un upload d'image
        if ($data["isUpload"]=="true") {
            $sfile = $requestFile["image"];
            $newName=$this->galerieService->saveImageGetDetail($sfile,$entreprise->getNomEntreprise()); 
            $totalSize=$totalSize+$newName["size"];
            $galerie = $this->galerieService->addNewGalerie($sfile,$newName,$entreprise);
            $image= $galerie->getDocumentUrl();
        }
        else{
            $image=$data["media"];
        }
        $slug=$this->slugService->clean_string($data["nom"]);
        // Vérifier si le slug n'existe pas  à resoudre plut tard
        $verify=$sousCategoryProductRepository->findOneBy(['isDeleted'=>false,'slug'=>$slug]);
        if($verify){
            if ($verify->getId() != $sousCategory->getId()) {
                return new JsonResponse(['message' => "Sous Catégorie déjas existence veuillez changer de nom de votre sous catégorie ou supprimer celle deja existante"], Response::HTTP_BAD_REQUEST);                  
            }
        }
        $sousCategory->setNom($data["nom"])
                     ->setDescription($data["detail"])
                     ->setImage($image)
                     ->setSlug($slug);
        $entityManagerInterface->persist($sousCategory);
        $entityManagerInterface->flush();
        return new JsonResponse(['message' => "Sous Catégorie modifier avec succés"], Response::HTTP_OK);  
    }
}
