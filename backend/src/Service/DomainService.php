<?php

namespace App\Service;

use App\Repository\ClientRepository;
use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;

class DomainService
{
    private $clientRepository;
    private $em;

    public function __construct(ClientRepository $clientRepository, EntityManagerInterface $em)
    {
        $this->clientRepository = $clientRepository;
        $this->em = $em;
    }

    /**
     * Récupère un client basé sur son domaine.
     * 
     * @param string $domain Le domaine du client.
     * @return Client|null
     */
    public function getClientByDomain(string $domain): ?Client
    {
        return $this->clientRepository->findOneBy(['domain' => $domain]);
    }

    /**
     * Vérifie si un domaine est disponible.
     * 
     * @param string $domain
     * @return bool
     */
    public function isDomainAvailable(string $domain): bool
    {
        $client = $this->clientRepository->findOneBy(['domain' => $domain]);
        return $client === null;
    }

    /**
     * Assigner un domaine à un client.
     * 
     * @param Client $client
     * @param string $domain
     * @return void
     */
    public function assignDomain(Client $client, string $domain): void
    {
        if ($this->isDomainAvailable($domain)) {
            $client->setDomain($domain);
            $this->em->persist($client);
            $this->em->flush();
        } else {
            throw new \Exception('Domaine déjà utilisé.');
        }
    }
}
