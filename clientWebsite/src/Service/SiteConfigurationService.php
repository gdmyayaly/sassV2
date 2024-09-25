<?php

namespace App\Service;

use App\Entity\Client;
use App\Repository\ClientRepository;

class SiteConfigurationService
{
    private $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function loadConfigurationForDomain(string $domain): ?Client
    {
        return $this->clientRepository->findOneBy(['domain' => $domain]);
    }
}
