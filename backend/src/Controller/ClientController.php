<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Site;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client_get',methods:['GET'])]
    public function allClient(ClientRepository $clientRepository,SerializerInterface $serializer): Response
    {
        $clients = $clientRepository->findAll();
        $data = $serializer->serialize($clients, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
       
    }
    #[Route('/client', name: 'app_client_add',methods:['POST'])]
    public function addNewClient(Request $request,EntityManagerInterface $entityManagerInterface): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $client = new Client();
        $client->setName($data["name"])
               ->setDomain($data["domain"]);
        $entityManagerInterface->persist($client);
        // Création du site du client
        $tabDefaultPage=[
            ["Accueil","",],
            ["Boutique","/boutique"],
            ["Contact","/contact"],

        ];
        for ($i=0; $i <count($tabDefaultPage) ; $i++) { 
            $site = new Site();
            $site->setPublished(true)
                 ->setClient($client)
                 ->setUrl($data["domain"].$tabDefaultPage[$i][1])
                 ->setPageName($tabDefaultPage[$i][0]);
            $entityManagerInterface->persist($site);
        }
        $entityManagerInterface->flush();
        return new JsonResponse(['message' => "Client créé avec succès."], Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/client/{id}', name: 'app_client_detail',methods:['GET'])]
    public function detailCLient(int $id,ClientRepository $clientRepository,SerializerInterface $serializer): Response
    {
        $clients = $clientRepository->find($id);
        $data = $serializer->serialize($clients, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
       
    }
}
