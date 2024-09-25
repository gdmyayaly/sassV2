<?php

namespace App\Controller\Client;

use App\Entity\CategoryProduct;
use App\Entity\Client;
use App\Entity\Galerie;
use App\Entity\User;
use App\Repository\CategoryProductRepository;
use App\Repository\ClientRepository;
use App\Repository\UserRepository;
use App\Service\GalerieService;
use App\Service\SlugService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/client')]

class CategoryProductController extends AbstractController
{
    private $galerieService;
    private $slugService;

    public function __construct(GalerieService $galerieService,SlugService $slugService)
    {
        $this->galerieService=$galerieService;
        $this->slugService=$slugService;
    }

    #[Route('/category',methods:['GET'])]
    function getAllCategory(CategoryProductRepository $categoryProductRepository,UserRepository $userRepository,SerializerInterface $serializer,ClientRepository $clientRepository):Response{        
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $category= $categoryProductRepository
        //->listeCategoriesEtSousCategoriesNonSupprimees($entreprise);
        ->findBy(['client'=>$entreprise,'isDeleted'=>false]);
        $data = $serializer->serialize($category, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/category',methods:['POST'])]
    function addCategoryProduct(Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManagerInterface,UserRepository $userRepository,ClientRepository $clientRepository,CategoryProductRepository $categoryProductRepository) : JsonResponse {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $requestFile=$request->files->all();
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
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
        $verify=$categoryProductRepository->findOneBy(['client'=>$entreprise,'isDeleted'=>false,'slug'=>$slug]);
        if($verify){
            return new JsonResponse(['message' => "Catégorie déjas existence veuillez changer de nom de catégorie ou supprimer celle deja existante"], Response::HTTP_BAD_REQUEST);  
        }
        $category = new CategoryProduct();
        $category->setNom($data["nom"])
                 ->setDescription($data["detail"])
                 ->setImage($image)
                 ->setClient($entreprise)
                 ->setCreteadAt(new DateTimeImmutable('now'))
                 ->setDeletedAt(new DateTimeImmutable('now'))
                 ->setIsDeleted(false)
                 ->setSlug($slug);
        $entityManagerInterface->persist($category);
        $entityManagerInterface->flush();
        return new JsonResponse(['message' => "Catégorie enregistrer avec succés"], Response::HTTP_OK);  

    }
    #[Route('/category/detail/{id}',methods:['GET'])]
    function getOneCategory(EntityManagerInterface $entityManager,int $id,SerializerInterface $serializer):Response{ 
        $user=$entityManager->getRepository(User::class)->find($this->getUser());
        $entreprise= $entityManager->getRepository(Client::class)->find($user->getUtilisateur()->getClient()->getId());
        $category= $entityManager->getRepository(CategoryProduct::class)->findOneBy(['client'=>$entreprise,'isDeleted'=>false,"id"=>$id]);
        $data = $serializer->serialize($category, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/category/remove',methods:['POST'])]
    function removeCategory(SerializerInterface $serializer,UserRepository $userRepository,ClientRepository $clientRepository,Request $request,EntityManagerInterface $entityManagerInterface,CategoryProductRepository $categoryProductRepository) : JsonResponse {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $totalSize=$entreprise->getGalerieSizeActuel();
        $category= $categoryProductRepository->find($data["id"]);
        if (!$category) {
            return new JsonResponse(['message' => "Catégorie non disponible"], Response::HTTP_BAD_REQUEST);  
        }
        $category->setIsDeleted(true)
                 ->setDeletedAt(new DateTimeImmutable('now'));
        $entityManagerInterface->persist($category);
        $entityManagerInterface->flush();
        return new JsonResponse(['message' => "Catégorie supprimer avec succées"], Response::HTTP_OK);  
    }
    #[Route('/category/update',methods:['POST'])]
    function updateCategoryProduct(SerializerInterface $serializer,Request $request,EntityManagerInterface $entityManagerInterface,UserRepository $userRepository,ClientRepository $clientRepository,CategoryProductRepository $categoryProductRepository) : JsonResponse {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $requestFile=$request->files->all();
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $totalSize=$entreprise->getGalerieSizeActuel();
        $image="";
        $category= $categoryProductRepository->findOneBy(["id"=>$data["id"],"client"=>$entreprise]);
        // Vérification si il a choisi une image de la galerie ou in a fait un upload d'image
        if ($data["isUpload"]=="true") {
            $sfile = $requestFile["image"];
            $newName=$this->galerieService->saveImageGetDetail($sfile,$entreprise->getNomEntreprise()); 
            $totalSize=$totalSize+$newName["size"];
            $galerie = $this->galerieService->addNewGalerie($sfile,$newName,$entreprise);
            $entityManagerInterface->persist($galerie);
            $image= $galerie->getDocumentUrl();
        }
        else{
            $image=$data["media"];
        }
        $slug=$this->slugService->clean_string($data["nom"]);
        // Vérifier si le slug n'existe pas  à resoudre plut tard
        $verify=$categoryProductRepository->findOneBy(['client'=>$entreprise,'isDeleted'=>false,'slug'=>$slug]);
        if($verify){
            if ($verify->getId() != $category->getId()) {
                return new JsonResponse(['message' => "Catégorie déjas existence veuillez changer de nom de catégorie ou supprimer celle deja existante"], Response::HTTP_BAD_REQUEST);                  
            }
        }
        $category->setNom($data["nom"])
                 ->setDescription($data["detail"])
                 ->setImage($image)
                 ->setSlug($slug);
        $entityManagerInterface->persist($category);
        $entityManagerInterface->flush();
        return new JsonResponse(['message' => "Catégorie modifier avec succés"], Response::HTTP_OK);  
    } 
}
