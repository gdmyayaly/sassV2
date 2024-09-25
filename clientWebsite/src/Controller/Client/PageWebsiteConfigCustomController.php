<?php

namespace App\Controller\Client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/client')]
class PageWebsiteConfigCustomController extends AbstractController
{
    #[Route('/page/website/config/custom', name: 'app_page_website_config_custom')]
    public function index(): Response
    {
        return $this->render('page_website_config_custom/index.html.twig', [
            'controller_name' => 'PageWebsiteConfigCustomController',
        ]);
    }
}
