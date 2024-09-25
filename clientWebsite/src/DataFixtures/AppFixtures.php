<?php

namespace App\DataFixtures;

use App\Entity\SectionTypeWebsitePage;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    // public function load(ObjectManager $manager): void
    // {
    //     // $product = new Product();
    //     // $manager->persist($product);

    //     $manager->flush();
    // }
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    // ...
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setRoles(["ROLE_ADMIN"]);
        $password = $this->hasher->hashPassword($user, 'Welcome123@');
        $user->setPassword($password);
        $manager->persist($user);
        $tabsSection=[
            ["nom"=>"Accueil","detail"=>"Module pour la gestion des Accueils"],
            ["nom"=>"Boutique","detail"=>"Modules pour la gestion des Boutiques"],
            ["nom"=>"Contact","detail"=>"Module pour la gestion des contacts"],
            ["nom"=>"CardProduct","detail"=>"Modules pour la gestion des CardProducts"],
            ["nom"=>"Menu","detail"=>"Modules pour la gestion des menu"],
            ["nom"=>"Footer","detail"=>"Modules pour la gestion des Footer"],

            // ["nom"=>"About","type"=>"section","detail"=>"Section qui contiendra toutes les différentes section about dans le page web"],
            // ["nom"=>"Banner","type"=>"section","detail"=>"Section qui contiendra toutes les différentes bannière"],
            // ["nom"=>"CardProduct","type"=>"section","detail"=>"Section qui contiendra toutes les différentes model de card qui serviront a afficher les produits"],
            // ["nom"=>"DetailCardProduct","type"=>"section","detail"=>"Section qui contiendra toutes les différentes model de card qui serviront a afficher les details produits"],
            // ["nom"=>"CardCategorie","type"=>"section","detail"=>"Section qui contiendra toutes les différentes model de card qui serviront a afficher les catégories et sous catégories de produit"],
        ];
        for ($i=0; $i <count($tabsSection) ; $i++) { 
            $SectionTypeWebsitePage = new SectionTypeWebsitePage();
            $SectionTypeWebsitePage->setNom($tabsSection[$i]["nom"])
                                   ->setSlug($tabsSection[$i]["nom"])
                                   ->setCommon(true)
                                   ->setDescription($tabsSection[$i]["detail"]);
            $manager->persist($SectionTypeWebsitePage);
        }
        $manager->flush();
    }
}
