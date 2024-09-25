<?php

namespace App\Controller\Client;

use App\Entity\Galerie;
use App\Repository\ClientRepository;
use App\Repository\GalerieRepository;
use App\Repository\UserRepository;
use App\Service\GalerieService;
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
class GalerieController extends AbstractController
{   
    private $galerieService;

    public function __construct(GalerieService $galerieService){
        $this->galerieService=$galerieService;
    }
    #[Route('/galerie',methods:['GET'])]
    function getAllGalerie(GalerieRepository $galerieRepository,UserRepository $userRepository,SerializerInterface $serializer,ClientRepository $clientRepository):Response{        
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $galerie= $galerieRepository->findBy(['client'=>$entreprise,'isDeleted'=>false]);
        $data = $serializer->serialize($galerie, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/galerie',methods:['POST'])]
    function addMediaGalerie(Request $request,EntityManagerInterface $entityManagerInterface,UserRepository $userRepository,ClientRepository $clientRepository):JsonResponse{        
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $requestFile=$request->files->all();
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $totalSize=$entreprise->getGalerieSizeActuel();
        for ($i=0; $i <count($requestFile) ; $i++) { 
            $alpha="image".$i;
            $sfile = $requestFile[$alpha];
            $newName=$this->galerieService->saveImageGetDetail($sfile,$entreprise->getNomEntreprise()); 
            $totalSize=$totalSize+$newName["size"];
            $galerie = $this->galerieService->addNewGalerie($sfile,$newName,$entreprise);
        }
        $entreprise->setGalerieSizeActuel($totalSize);
        $entityManagerInterface->persist($entreprise);
        $entityManagerInterface->flush();
        return new JsonResponse(['message' => "Image enregistrer avec succes"], Response::HTTP_OK);  

    }
    #[Route('/galerie/remove',methods:['POST'])]
    function removeMedia(Request $request,EntityManagerInterface $entityManagerInterface,GalerieRepository $galerieRepository,UserRepository $userRepository,ClientRepository $clientRepository) : JsonResponse {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $totalSize=$entreprise->getGalerieSizeActuel();
        $galerie= $galerieRepository->findOneBy(["id"=>$data["id"],"client"=>$entreprise]);
        if (!$galerie) {
            return new JsonResponse(['message' => "Image non disponible"], Response::HTTP_BAD_REQUEST);  
        }
        $galerie->setIsDeleted(true)
                ->setDeletedAt(new DateTimeImmutable('now'));
        $entityManagerInterface->persist($galerie);
        $totalSize= $totalSize - $galerie->getDocumentSize();
        $entreprise->setGalerieSizeActuel($totalSize);
        $entityManagerInterface->persist($entreprise);
        $entityManagerInterface->flush();
        $delPath=$this->getParameter('chemin') .DIRECTORY_SEPARATOR.$entreprise->getNomEntreprise().DIRECTORY_SEPARATOR. 'remove';
        $message=$this->galerieService->moveMediaFile($galerie->getPath(),$delPath,$galerie->getDocumentNewName());
        return new JsonResponse(['message' => "Image supprimer avec succées"], Response::HTTP_OK);  

    }
    
}
