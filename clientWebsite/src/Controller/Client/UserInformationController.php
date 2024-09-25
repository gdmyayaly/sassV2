<?php

namespace App\Controller\Client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserInformationController extends AbstractController
{
    #[Route('/api/client/user', name: 'app_user_information_detail')]
    public function index(SerializerInterface $serializer): Response
    {
        $user = $this->getUser();
        $data = $serializer->serialize($user, 'json', [
            'groups' => ['user']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
        // return $this->render('user_information/index.html.twig', [
        //     'controller_name' => 'UserInformationController',
        // ]);
    }
}
