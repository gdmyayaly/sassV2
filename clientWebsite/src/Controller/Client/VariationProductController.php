<?php

namespace App\Controller\Client;

use App\Entity\VariationProduct;
use App\Repository\ClientRepository;
use App\Repository\UserRepository;
use App\Repository\VariationProductRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/client')]
class VariationProductController extends AbstractController
{
    #[Route('/variation-product',methods:['GET'])]
    function getConfig(VariationProductRepository $variationProductRepository,UserRepository $userRepository,SerializerInterface $serializer,ClientRepository $clientRepository) : Response {
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $variationProduct= $variationProductRepository->findBy(['client'=>$entreprise,'isDeleted'=>false]);
        $data = $serializer->serialize($variationProduct, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/variation-product',methods:['POST'])]
    function addnewVariation(Request $request,UserRepository $userRepository,EntityManagerInterface $entityManagerInterface,ClientRepository $clientRepository) : JsonResponse {
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $configVariationProduct = new VariationProduct();
        $configVariationProduct->setNom($data["nom"])
                               ->setValeur($data["valeur"])
                               ->setClient($entreprise)
                               ->setIsDeleted(false)
                               ->setCreatedAt(new DateTimeImmutable('now'))
                               ->setDeletedAt(new DateTimeImmutable('now'));
        $entityManagerInterface->persist($configVariationProduct);
        $entityManagerInterface->flush();
        return new JsonResponse(['message' => "Variation ajoutée avec succée"], Response::HTTP_OK);  

    }
    #[Route('/variation-product/detail',methods:['POST'])]
    function getDetailOneVariation(Request $request,VariationProductRepository $variationProductRepository,UserRepository $userRepository,SerializerInterface $serializer,ClientRepository $clientRepository) : Response {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $variationProduct= $variationProductRepository->findOneBy(['client'=>$entreprise,'isDeleted'=>false,"id"=>$data["id"]]);
        if(!$variationProduct){
            return new JsonResponse(['message' => "Variation non disponible"], Response::HTTP_BAD_REQUEST);  
        }
        $data = $serializer->serialize($variationProduct, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/variation-product/update',methods:['POST'])]
    function updateOneVariationProduct(Request $request,UserRepository $userRepository,EntityManagerInterface $entityManagerInterface,ClientRepository $clientRepository,VariationProductRepository $variationProductRepository) : JsonResponse {
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $configVariationProduct= $variationProductRepository->findOneBy(['client'=>$entreprise,'isDeleted'=>false,"id"=>$data["id"]]);
        if(!$configVariationProduct){
            return new JsonResponse(['message' => "Variation non disponible"], Response::HTTP_BAD_REQUEST);  
        }
        $configVariationProduct->setNom($data["nom"])
                               ->setValeur($data["valeur"]);
        $entityManagerInterface->persist($configVariationProduct);
        $entityManagerInterface->flush();
        return new JsonResponse(['message' => "Variation modifier avec succée"], Response::HTTP_OK);  

    }
    #[Route('/variation-product/remove',methods:['POST'])]
    function removeOneVariationProduct(Request $request,UserRepository $userRepository,EntityManagerInterface $entityManagerInterface,ClientRepository $clientRepository,VariationProductRepository $variationProductRepository) : JsonResponse {
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $configVariationProduct= $variationProductRepository->findOneBy(['client'=>$entreprise,'isDeleted'=>false,"id"=>$data["id"]]);
        if(!$configVariationProduct){
            return new JsonResponse(['message' => "Variation non disponible"], Response::HTTP_BAD_REQUEST);  
        }
        $configVariationProduct->setIsDeleted(true)
                               ->setDeletedAt(new DateTimeImmutable('now'));
        $entityManagerInterface->persist($configVariationProduct);
        $entityManagerInterface->flush();
        return new JsonResponse(['message' => "Variation supprimer avec succée"], Response::HTTP_OK);  

    }
}
