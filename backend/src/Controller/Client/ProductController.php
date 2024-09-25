<?php

namespace App\Controller\Client;

use App\Entity\Product;
use App\Entity\ProductCategoryValue;
use App\Entity\ProductVariationValue;
use App\Repository\CategoryProductRepository;
use App\Repository\ClientRepository;
use App\Repository\GalerieRepository;
use App\Repository\ProductCategoryValueRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductVariationValueRepository;
use App\Repository\SousCategoryProductRepository;
use App\Repository\UserRepository;
use App\Repository\VariationProductRepository;
use App\Service\GalerieService;
use App\Service\SlugService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/client')]
class ProductController extends AbstractController
{
    private $galerieService;
    private $slugService;

    public function __construct(GalerieService $galerieService,SlugService $slugService)
    {
        $this->galerieService=$galerieService;
        $this->slugService=$slugService;
    }
   
    #[Route('/product',methods:['GET'])]
    function listProduct(ProductRepository $productRepository,UserRepository $userRepository,SerializerInterface $serializer,ClientRepository $clientRepository) : Response {
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $allProduct= $productRepository->findBy(['client'=>$entreprise,'isDeleted'=>false]);
        $data = $serializer->serialize($allProduct, 'json', [
            'groups' => ['listProduct']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/product',methods:['POST'])]
    function addProduct(SerializerInterface $serializer,Request $request,UserRepository $userRepository,ClientRepository $clientRepository,CategoryProductRepository $categoryProductRepository,GalerieRepository $galerieRepository,VariationProductRepository $variationProductRepository,EntityManagerInterface $entityManagerInterface,SousCategoryProductRepository $sousCategoryProductRepository,ProductRepository $productRepository) : JsonResponse {
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $requestFile=$request->files->all();
        // Insertion du produit
        $prix=$data["prix"];
        $prix = ($prix=="") ? null : $prix;
        $prixPromo=$data["prixPromo"];
        $prixPromo = ($prixPromo=="") ? null : $prixPromo;
        $promoStart=$data["promoStart"];
        $promoStart = ($promoStart=="") ? null : new DateTimeImmutable($promoStart);
        $promoEnd=$data["promoEnd"];
        $promoEnd = ($promoEnd=="") ? null : new DateTimeImmutable($promoEnd);
        $quantity= ($data["qt"]=="") ? null : $data["qt"];
        $colorCount=$data["colorCount"];
        $colors=[];
        $colors = ($colorCount=="0" && $data["color0"]="") ? [] :[$data["color0"]] ;
        if ((int)$colorCount>=1) {
            $colors=[];
            for ($i=0; $i <=$colorCount ; $i++) { 
                array_push($colors,$data["color$i"]);
            }
        }
        $countGalerie=$data["countGalerie"];
        $countUpload=$data["countUpload"];
        $otherImage=[];
        $otherVideo=[];
        if ($countGalerie>=1) {
            for ($i=0; $i <$countGalerie ; $i++) {
                // Vérification si c'est video ou image comme media
                if ($this->getTypeMediaFromURL($data["imageGalerie$i"])=="video") {
                    array_push($otherVideo,$data["imageGalerie$i"]);
                }
                elseif($this->getTypeMediaFromURL($data["imageGalerie$i"])=="image"){
                    array_push($otherImage,$data["imageGalerie$i"]);
                }
            }
        }
        if ($countUpload>=1) {
            $totalSize=$entreprise->getGalerieSizeActuel();
            for ($i=0; $i <$countUpload ; $i++) { 
                $sfile = $requestFile["imageUpload$i"];
                $newName=$this->galerieService->saveImageGetDetail($sfile,$entreprise->getNomEntreprise()); 
                $totalSize=$totalSize+$newName["size"];
                $galerie = $this->galerieService->addNewGalerie($sfile,$newName,$entreprise);
                // $galerie = new Galerie();
                // $galerie->setDocumentOriginalName($sfile->getClientOriginalName())
                //         ->setDocumentNewName($newName["name"])
                //         ->setDocumentType($newName["type"])
                //         ->setDocumentUrl($this->domaineMedia.$entreprise->getNomEntreprise(). '/' . $newName["name"])
                //         ->setShowPublic(false)
                //         ->setIsDeleted(false)
                //         ->setCretedAt(new DateTimeImmutable('now'))
                //         ->setDeletedAt(new DateTimeImmutable('now'))
                //         ->setPasswordMedia(null)
                //         ->setPath($this->getParameter('chemin') .'/'.$entreprise->getNomEntreprise(). '/' . $newName["name"])
                //         ->setEntreprise($entreprise);
                // $galerie->setDocumentSize($newName["size"]);
                // $entityManagerInterface->persist($galerie);
                // array_push($otherImage,$galerie->getDocumentUrl());
                if (str_contains($galerie->getDocumentUrl(), 'video')) {array_push($otherVideo,$galerie->getDocumentUrl());}
                if (str_contains($galerie->getDocumentUrl(), 'image')) {array_push($otherImage,$galerie->getDocumentUrl());}

            }
            $entreprise->setGalerieSizeActuel($totalSize);
            $entityManagerInterface->persist($entreprise);
        }
        $imageFile="";

        if (array_key_exists("imagePrincipalUpload",$requestFile)) {
            $sfile = $requestFile["imagePrincipalUpload"];
            $newName=$this->galerieService->saveImageGetDetail($sfile,$entreprise->getNomEntreprise()); 
            $sizeMedia=$newName["size"];
            $galerie = $this->galerieService->addNewGalerie($sfile,$newName,$entreprise);
            // $galerie = new Galerie();
            // $galerie->setDocumentOriginalName($sfile->getClientOriginalName())
            //         ->setDocumentNewName($newName["name"])
            //         ->setDocumentType($newName["type"])
            //         ->setDocumentUrl($this->domaineMedia.$entreprise->getNomEntreprise(). '/' . $newName["name"])
            //         ->setShowPublic(false)
            //         ->setIsDeleted(false)
            //         ->setCretedAt(new DateTimeImmutable('now'))
            //         ->setDeletedAt(new DateTimeImmutable('now'))
            //         ->setPasswordMedia(null)
            //         ->setPath($this->getParameter('chemin') .'/'.$entreprise->getNomEntreprise(). '/' . $newName["name"])
            //         ->setEntreprise($entreprise);
            // $galerie->setDocumentSize($newName["size"]);
            // $entityManagerInterface->persist($galerie);
            $entreprise->setGalerieSizeActuel($entreprise->getGalerieSizeActuel()+$sizeMedia);
            $entityManagerInterface->persist($entreprise);
            $imageFile=$galerie->getDocumentUrl();
        } 
        if (array_key_exists('imagePrincipal',$data)) {
            $imageFile=$data["imagePrincipal"];
        }
        $slug=$this->slugService->clean_string($data["nom"]);
        $produit= new Product();
        $produit->setNom($data["nom"])
                ->setSlug($slug)
                ->setBrefDescription($data["brefDescription"])
                ->setDetailDescription($data["detailDescription"])
                ->setQuantity($quantity)
                ->setPrix($prix)
                ->setPrixPromo($prixPromo)
                ->setPromoStart($promoStart)
                ->setPromoEnd($promoEnd)
                ->setImage($imageFile)
                ->setOtherImage($otherImage)
                ->setOtherVideo($otherVideo)
                ->setColors($colors)
                ->setClient($entreprise);
        $entityManagerInterface->persist($produit);
        // Attribution de categorie et sous categorie du produit
        $tabsCat=$data["categorie"];
        $tabsCat= explode(",",$tabsCat);
        for ($j=0; $j < count($tabsCat); $j++) { 
            $category= $categoryProductRepository->find($tabsCat[$j]);
            $sousCategory= $sousCategoryProductRepository->find($tabsCat[$j]);
            if (!$category && !$sousCategory) {
                return new JsonResponse(['message' => "Information incorrect"], Response::HTTP_BAD_REQUEST);  
            }
            $productCategorie = new ProductCategoryValue();
            $productCategorie->setCategory($category);
            $productCategorie->setSousCategory($sousCategory);
            $productCategorie->setProduct($produit);
            $entityManagerInterface->persist($productCategorie);
        }

 
        // get all variation from entreprise
        $entrepriseVariationProduct= $variationProductRepository->findBy(['client'=>$entreprise,'isDeleted'=>false]);
        if (count($entrepriseVariationProduct)>=1 ) {
            foreach ($entrepriseVariationProduct as $key => $value) {
                if (array_key_exists($value->getNom(),$data)) {
                    $valeur=$data[$value->getNom()];
                    $valeurTab = explode("&", $valeur);
                    $valeurNewTab = [];
                    foreach ($valeurTab as $keyTab => $valueTabs) {
                        if ($valueTabs!="vide") {
                            array_push($valeurNewTab,$valueTabs);
                        }
                    }
                    $variationProductValue = new ProductVariationValue();
                    $variationProductValue->setProduct($produit)
                                      ->setVariationProduct($value)
                                      ->setValue($valeurNewTab)
                                      ->setIsDeleted(false);
                    $entityManagerInterface->persist($variationProductValue);
                }
            }   
        }
        $entityManagerInterface->flush();
        // // Call API du client site pour ajouter cette une categorie
        // $tokenUser=$user->getCurrentToken();
        // $lastProductInsert=$productRepository->findOneBy([
        //                                                     'client'=>$entreprise,
        //                                                     'isDeleted'=>false,
        //                                                     'nom'=>$produit->getNom(),
        //                                                     'brefDescription'=>$produit->getBrefDescription(),
        //                                                     'detailDescription'=>$produit->getDetailDescription()
        //                                                 ]);

        // $dataToSend = $serializer->serialize($lastProductInsert, 'json', [
        //     'groups' => ['listProduct']
        // ]);
        // $dataVariationProduct=$serializer->serialize($lastProductInsert->getProductVariationValues(), 'json', [
        //     'groups' => ['listProduct']
        // ]);
        // // $produit->setNom($data["nom"])
        // //         ->setBrefDescription($data["brefDescription"])
        // //         ->setDetailDescription($data["detailDescription"])
        // //         ->setQuantity($quantity)
        // //         ->setPrix($prix)
        // //         ->setPrixPromo($prixPromo)
        // //         ->setPromoStart($promoStart)
        // //         ->setPromoEnd($promoEnd)
        // //         ->setImage($imageFile)
        // //         ->setOtherImage($otherImage)
        // //         ->setOtherVideo($otherVideo)
        // //         ->setColors($colors)
        // //         ->setEntreprise($entreprise);
        // $tabData=[
        //     "externalId"=>$lastProductInsert->getId(),
        //     "valeur"=>$dataToSend,
        //     "categorie"=>$data["categorie"],
        //     "nom"=>$produit->getNom(),
        //     "brefDescription"=>$produit->getBrefDescription(),
        //     "detailDescription"=>$produit->getDetailDescription(),
        //     "image"=>$produit->getImage(),
        //     "otherImage"=>$produit->getOtherImage(),
        //     "otherVideo"=>$produit->getOtherVideo(),
        //     "prix"=>$produit->getPrix(),
        //     "prixPromo"=>$produit->getPrixPromo(),
        //     "promoStart"=>$produit->getPromoStart(),
        //     "promoEnd"=>$produit->getPromoEnd(),
        //     "colors"=>$produit->getColors(),
        //     "quantity"=>$produit->getQuantity(),
        //     "othreVariation"=>$dataVariationProduct
        // ];
        // $response = $this->client->request(
        //     'POST',
        //     $entreprise->getLinkWebsite()."/api/add/product",[
        //         'headers' => ['Accept' => 'application/json','Authorization'=>"Bearer $tokenUser"],
        //         'json' => $tabData,
        // ]);
        // $decodedPayload=$response->toArray();
        // if ($decodedPayload["message"]=="Parfait") {
        return new JsonResponse(['message' => "Produit enregistrer avec succes"], Response::HTTP_OK);  
        // }
        // else{
        //     $produit->setIsDeleted(true);
        //     $entityManagerInterface->persist($produit);
        //     $entityManagerInterface->flush();
        //     return new JsonResponse(['message' => "Erreur sur l'enregistrement de votre Produit"], Response::HTTP_BAD_REQUEST);  
        // }  
        // return new JsonResponse(['message' => "Produit enregistrer avec succes","data"=>$dataToSend], Response::HTTP_OK);        

    }
    #[Route('/product/remove',methods:['POST'])]
    function removeProduct(SerializerInterface $serializer,Request $request,EntityManagerInterface $entityManagerInterface,UserRepository $userRepository,ClientRepository $clientRepository,ProductRepository $productRepository) : JsonResponse {
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $data = json_decode($request->getContent(),true);
        if(!$data){
            $data=$request->request->all();
        }
        $product = $productRepository->findOneBy(["id"=>$data["id"],"client"=>$entreprise]);
        if(!$product){
            return new JsonResponse(['message' => "Produit non disponible"], Response::HTTP_BAD_REQUEST);  
        }
        $product->setIsDeleted(true);
        $product->setDeletedAt(new DateTimeImmutable('now'));
        $entityManagerInterface->persist($product);
        // $entityManagerInterface->flush();
        // Call API du client site pour ajouter cette une categorie
        // $tokenUser=$user->getCurrentToken();
        // $dataToSend = $serializer->serialize($product, 'json', [
        //     'groups' => ['listProduct']
        // ]);
        // $tabData=["externalId"=>$product->getId(),"valeur"=>$dataToSend];
        // $response = $this->client->request(
        //     'POST',
        //     $entreprise->getLinkWebsite()."/api/remove/product",[
        //         'headers' => ['Accept' => 'application/json','Authorization'=>"Bearer $tokenUser"],
        //         'json' => $tabData,
        // ]);

        // $decodedPayload=$response->toArray();
        // if ($decodedPayload["message"]=="Parfait") {
        //     $entityManagerInterface->flush();
        //     return new JsonResponse(['message' => "Produit supprimer avec succée"], Response::HTTP_OK);  
        // }
        // else{
        //     $product->setIsDeleted(false);
        //     $entityManagerInterface->persist($product);
        //     $entityManagerInterface->flush();
        //     return new JsonResponse(['message' => "Erreur sur l'enregistrement de votre Produit"], Response::HTTP_BAD_REQUEST);  
        // }   
        $entityManagerInterface->flush();
        return new JsonResponse(['message' => "Produit supprimer avec succée"], Response::HTTP_OK);  
    }
    #[Route('/product/detail/{id}',methods:['GET'])]
    function detailProduct(int $id,ProductRepository $productRepository,UserRepository $userRepository,SerializerInterface $serializer,ClientRepository $clientRepository) : Response {
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $allProduct= $productRepository->findOneBy(['client'=>$entreprise,'isDeleted'=>false,'id'=>$id]);
        $data = $serializer->serialize($allProduct, 'json', [
            'groups' => ['listProduct']
        ]);
        return new Response($data, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
    #[Route('/product/edit/{id}',methods:['POST'])]

    function editProduct(int $id,Request $request,ProductRepository $productRepository,VariationProductRepository $variationProductRepository,ProductVariationValueRepository $productVariationValueRepository,CategoryProductRepository $categoryProductRepository,SousCategoryProductRepository $sousCategoryProductRepository,UserRepository $userRepository,SerializerInterface $serializer,ClientRepository $clientRepository,EntityManagerInterface $entityManagerInterface,ProductCategoryValueRepository $productCategoryValueRepository)  {
        $user= $userRepository->find($this->getUser());
        $entreprise= $clientRepository->find($user->getUtilisateur()->getClient()->getId());
        $product= $productRepository->findOneBy(['client'=>$entreprise,'isDeleted'=>false,'id'=>$id]);
        $data = json_decode($request->getContent(),true);
        $requestFile=$request->files->all();
        if(!$data){
            $data=$request->request->all();
        }
        $tabData=[];
        // Vérification du type de modification
        if (array_key_exists('nameOrImage',$data)) {
            $imageFile=$product->getImage();
            if (array_key_exists("imagePrincipalUpload",$requestFile)) {
                $sfile = $requestFile["imagePrincipalUpload"];
                $newName=$this->galerieService->saveImageGetDetail($sfile,$entreprise->getNomEntreprise()); 
                $sizeMedia=$newName["size"];
                $galerie = $this->galerieService->addNewGalerie($sfile,$newName,$entreprise);
                // $galerie = new Galerie();
                // $galerie->setDocumentOriginalName($sfile->getClientOriginalName())
                //         ->setDocumentNewName($newName["name"])
                //         ->setDocumentType($newName["type"])
                //         ->setDocumentUrl($this->domaineMedia.$entreprise->getNomEntreprise(). '/' . $newName["name"])
                //         ->setShowPublic(false)
                //         ->setIsDeleted(false)
                //         ->setCretedAt(new DateTimeImmutable('now'))
                //         ->setDeletedAt(new DateTimeImmutable('now'))
                //         ->setPasswordMedia(null)
                //         ->setPath($this->getParameter('chemin') .'/'.$entreprise->getNomEntreprise(). '/' . $newName["name"])
                //         ->setEntreprise($entreprise);
                // $galerie->setDocumentSize($newName["size"]);
                // $entityManagerInterface->persist($galerie);
                $entreprise->setGalerieSizeActuel($entreprise->getGalerieSizeActuel()+$sizeMedia);
                $entityManagerInterface->persist($entreprise);
                $imageFile=$galerie->getDocumentUrl();
            } 
            if (array_key_exists('imagePrincipal',$data)) {
                $imageFile=$data["imagePrincipal"];
            }
            $slug=$this->slugService->clean_string($data["nom"]);
            $product->setNom($data["nom"]);
            $product->setSlug($slug);
            $product->setImage($imageFile);
            $entityManagerInterface->persist($product);
            // array_push($dataToSend,["nom"=>$data["nom"],"image"=>$imageFile]);
        }
        if (array_key_exists('categorieUpdate',$data)) {
            // On supprime les précédent catégorie et on lui attribue les nouveaux
            $productCategoryValue=$productCategoryValueRepository->findBy(["product"=>$product]);
            for ($i=0; $i <count($productCategoryValue) ; $i++) { 
                $entityManagerInterface->remove($productCategoryValue[$i]);
                // $productCategoryValue[$i]->setOldCategory($productCategoryValue[$i]->getCategory()->getId())
                //                          ->setOldSousCategory($productCategoryValue[$i]->getSousCategory()->getId())
                //                          ->setCategory(null)
                //                          ->setSousCategory(null);   
            }
            $entityManagerInterface->flush();
            $tabsCat=$data["categorie"];
            $tabsCat= explode(",",$tabsCat);
            for ($j=0; $j < count($tabsCat); $j++) { 
                $category= $categoryProductRepository->find($tabsCat[$j]);
                $sousCategory= $sousCategoryProductRepository->find($tabsCat[$j]);
    
                // if (!$category) {
                //     $category=null;
                    
                // }
                // if (!$sousCategory) {
                // }
                if (!$category && !$sousCategory) {
                    return new JsonResponse(['message' => "Information incorrect"], Response::HTTP_BAD_REQUEST);  
                }
                $productCategorie = new ProductCategoryValue();
                $productCategorie->setCategory($category);
                $productCategorie->setSousCategory($sousCategory);
                $productCategorie->setProduct($product);
                $entityManagerInterface->persist($productCategorie);
            }
            $entityManagerInterface->persist($product);
        }
        if (array_key_exists('detailUpdate',$data)) {
            $prix = ($data["prix"]=="") ? null : $data["prix"];
            $prixPromo = ($data["prixPromo"]=="") ? null : $data["prixPromo"];
            $promoStart = ($data["promoStart"]=="") ? null : new DateTimeImmutable($data["promoStart"]);
            $promoEnd = ($data["promoEnd"]=="") ? null : new DateTimeImmutable($data["promoEnd"]);
            $quantity= ($data["qt"]=="") ? null : $data["qt"];
            $colorCount=$data["colorCount"];
            $colors=[];
            $colors = ($colorCount=="0" && $data["color0"]=="") ? [] :[$data["color0"]] ;
            if ((int)$colorCount>=1) {
                $colors=[];
                for ($i=0; $i <=$colorCount ; $i++) { 
                    array_push($colors,$data["color$i"]);
                }
            }
            // Suppréssion des variation précédente
            $lastVatiationProduct=$productVariationValueRepository->findBy(["product"=>$product]);
            for ($i=0; $i <count($lastVatiationProduct) ; $i++) { 
                $entityManagerInterface->remove($lastVatiationProduct[$i]);
            }
            $entityManagerInterface->flush();
            $product->setBrefDescription($data["brefDescription"])
                    ->setDetailDescription($data["detailDescription"])
                    ->setQuantity($quantity)
                    ->setPrix($prix)
                    ->setPrixPromo($prixPromo)
                    ->setPromoStart($promoStart)
                    ->setPromoEnd($promoEnd)
                    ->setColors($colors);
            $entityManagerInterface->persist($product);
            $entrepriseVariationProduct= $variationProductRepository->findBy(['client'=>$entreprise,'isDeleted'=>false]);
            if (count($entrepriseVariationProduct)>=1 ) {
                foreach ($entrepriseVariationProduct as $key => $value) {
                    if (array_key_exists($value->getNom(),$data)) {
                        $valeur=$data[$value->getNom()];
                        $valeurTab = explode("&", $valeur);
                        $valeurNewTab = [];
                        foreach ($valeurTab as $keyTab => $valueTabs) {
                            if ($valueTabs!="vide") {
                                array_push($valeurNewTab,$valueTabs);
                            }
                        }
                        $variationProductValue = new ProductVariationValue();
                        $variationProductValue->setProduct($product)
                                          ->setVariationProduct($value)
                                          ->setValue($valeurNewTab)
                                          ->setIsDeleted(false);
                        $entityManagerInterface->persist($variationProductValue);
                    }
                }   
            }
        }
        // $dataToSends = $serializer->serialize($product, 'json', [
        //     'groups' => ['listProduct']
        // ]);
        // $tokenUser=$user->getCurrentToken();
        // $dataVariationProduct=$serializer->serialize($product->getProductVariationValues(), 'json', [
        //     'groups' => ['listProduct']
        // ]);
        // $tabData=[
        //     "externalId"=>$product->getId(),
        //     "valeur"=>$dataToSends,
        //     "nom"=>$product->getNom(),
        //     "brefDescription"=>$product->getBrefDescription(),
        //     "detailDescription"=>$product->getDetailDescription(),
        //     "image"=>$product->getImage(),
        //     "otherImage"=>$product->getOtherImage(),
        //     "otherVideo"=>$product->getOtherVideo(),
        //     "prix"=>$product->getPrix(),
        //     "prixPromo"=>$product->getPrixPromo(),
        //     "promoStart"=>$product->getPromoStart(),
        //     "promoEnd"=>$product->getPromoEnd(),
        //     "colors"=>$product->getColors(),
        //     "quantity"=>$product->getQuantity(),
        //     "othreVariation"=>$dataVariationProduct
        // ];
        // if (array_key_exists('categorieUpdate',$data)) {
        //    $tabData["categorie"]=$data["categorie"];
        // }
        // // return new JsonResponse(['message' => $tabData], Response::HTTP_OK);  
        // $response = $this->client->request(
        //     'POST',
        //     $entreprise->getLinkWebsite()."/api/edit/product",[
        //         'headers' => ['Accept' => 'application/json','Authorization'=>"Bearer $tokenUser"],
        //         'json' => $tabData,
        // ]);
        // $decodedPayload=$response->toArray();
        // if ($decodedPayload["message"]=="Parfait") {
        $entityManagerInterface->flush();
        return new JsonResponse(['message' => "Produit modifier avec succes"], Response::HTTP_OK);  
        //     return new Response($dataToSends, Response::HTTP_OK, [
        //         'Content-Type' => 'application/json'
        //     ]);
        // }
        // else{
        //     // $product->setIsDeleted(true);
        //     // $entityManagerInterface->persist($product);
        //     // $entityManagerInterface->flush();
        //     return new JsonResponse(['message' => "Erreur sur la modification de votre Produit","message"=>$decodedPayload["other"]], Response::HTTP_BAD_REQUEST);  
        // } 
        // return new Response($data, Response::HTTP_OK, [
        //     'Content-Type' => 'application/json'
        // ]);
    }
    // public function saveimage($file,$name){
    //     try {
    //     $fileName = md5(uniqid()) . '.' . $file->guessExtension();
    //     $type=$file->getMimeType();
    //     $size=$file->getSize();
    //     $file->move($this->getParameter('chemin').'/'.$name, $fileName);
    //     return ["name"=>$fileName,"type"=>$type,"size"=>$size];
    //     } 
    //     catch (FileException $e) {
    //         throw $e;
    //     } 
    // }
    function getTypeMediaFromURL($url) {
        $extension = strtolower(pathinfo($url, PATHINFO_EXTENSION));
      
        switch ($extension) {
          case 'jpg':
          case 'jpeg':
          case 'png':
          case 'gif':
            return 'image';
          case 'mp4':
          case 'webm':
          case 'avi':
          case 'mov':
            return 'video';
          default:
            return 'unknown';
        }
      }
}
