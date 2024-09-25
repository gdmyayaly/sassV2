<?php

namespace App\Service;

use App\Entity\Galerie;
use App\Entity\Client;
use App\Repository\GalerieRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RequestStack;

class GalerieService
{

    private $params;
    const DIRECTORY_SEPARATOR ="\\";
    protected string $domaineMedia ="http://localhost:8001/images/";
    protected $baseUrl;
    private $galerieRepository;
    private $em;

    public function __construct(ParameterBagInterface $params,RequestStack $requestStack,GalerieRepository $galerieRepository,EntityManagerInterface $em)
    {
        $this->params = $params;
        $this->baseUrl = $requestStack->getCurrentRequest()->getSchemeAndHttpHost();
        $this->domaineMedia=$this->baseUrl.DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR;
        $this->galerieRepository=$galerieRepository;
        $this->em = $em;

    }
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    //   /**
    //  * saveImage .
    //  * 
    //  * @param File $file
    //  * @param string $name
    //  * @return string
    //  */
    public function saveimage($file,$name){
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        $file->move($this->getParamName('chemin').DIRECTORY_SEPARATOR.$name, $fileName);
        return $fileName;
    }
    public function saveImageGetDetail($file,$name){
        try {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        $type=$file->getMimeType();
        $size=$file->getSize();
        $file->move($this->getParamName('chemin').DIRECTORY_SEPARATOR.$name, $fileName);
        return ["name"=>$fileName,"type"=>$type,"size"=>$size];
        } 
        catch (FileException $e) {
            throw $e;
        } 
    }
    public function moveMediaFile($cheminSource, $nouveauChemin,$name){
        if (file_exists($cheminSource)) {
            // Déplacer le fichier vers le nouveau répertoire
            if (!is_dir($nouveauChemin)) {
                mkdir($nouveauChemin, 0777, true);
            }
            if (rename($cheminSource, $nouveauChemin.DIRECTORY_SEPARATOR.$name)) {
                return "Le fichier a été supprimer avec succès.";
            } else {
                return "Une erreur s'est produite lors de la suppression du fichier.";
            }
        } else {
            return "Le fichier source n'existe pas.";
        }
    }
    public function getParamName($name)
    {
        return $this->params->get($name);
    }
      /**
     * Assigner un domaine à un client.
     * @param Array $newName
     * @param File $file
     * @param Client $entreprise
     * @return Galerie
     */
    public function addNewGalerie($file,$newName,Client $entreprise): ?Galerie{
        $galerie = new Galerie();
        $galerie->setDocumentOriginalName($file->getClientOriginalName())
                ->setDocumentNewName($newName["name"])
                ->setDocumentType($newName["type"])
                ->setDocumentUrl($this->domaineMedia.$entreprise->getNomEntreprise(). DIRECTORY_SEPARATOR . $newName["name"])
                ->setShowPublic(false)
                ->setIsDeleted(false)
                ->setCretedAt(new DateTimeImmutable('now'))
                ->setDeletedAt(new DateTimeImmutable('now'))
                ->setPasswordMedia(null)
                ->setPath($this->getParamName('chemin') .DIRECTORY_SEPARATOR.$entreprise->getNomEntreprise(). DIRECTORY_SEPARATOR . $newName["name"])
                ->setClient($entreprise);
        $galerie->setDocumentSize($newName["size"]);
        $this->em->persist($galerie);
        $this->em->flush();
        return $galerie;
    }
}
