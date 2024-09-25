<?php

namespace App\Controller\Client;

use App\Repository\ClientRepository;
use App\Repository\ClientSectionRepository;
use App\Repository\SectionTypeWebsitePageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/client')]
class PageWebsiteConfigDefaultController extends AbstractController
{
    // list des modules excluants celle de menu,cardProduct,Accueil,Boutique,Contact,Footer
    #[Route('/clientmodules', name: 'list_clientmodules')]
    public function index(ClientSectionRepository $clientSectionRepository,SerializerInterface $serializer,UserRepository $userRepository,ClientRepository $clientRepository): Response
    {
        $user= $userRepository->find($this->getUser());
        $client= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $sectionList=$clientSectionRepository->findSectionsByClientAndIsDefault($client->getId());
        $data = $serializer->serialize($sectionList, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    // Récupèration de la liste des section_type_website_page ayant is_common=true (les sectionType par defaut)
    #[Route('/clientdefaultsectiontype', name: 'list_clientdefaultsectiontype')]
    public function getAllDefaultSectionType(SerializerInterface $serializer,SectionTypeWebsitePageRepository $sectionTypeWebsitePageRepository): Response
    {
        $allClient= $sectionTypeWebsitePageRepository->findBy(['isCommon'=>true]);
        $data = $serializer->serialize($allClient, 'json', [
            'groups' => ['viewAdmin']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    // Récupèration de la liste des sections des section_type_website_page ayant is_common=true (les sectionType par defaut)
    #[Route('/clientdefaultsectiontypedetail/{id}', name: 'list_clientdefaultsectiontypedetail')]
    public function getAllDefaultSectionTypeDetail(int $id,SerializerInterface $serializer,ClientSectionRepository $clientSectionRepository,UserRepository $userRepository,ClientRepository $clientRepository): Response
    {
        $user= $userRepository->find($this->getUser());
        $client= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $sectionList=$clientSectionRepository->findSectionsByClientAndSectionTypeName($client->getId(),$id);
        $data = $serializer->serialize($sectionList, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
}
