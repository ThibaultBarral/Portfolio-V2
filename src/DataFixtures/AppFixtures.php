<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Projet;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface  $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Utilisation de Faker
        $faker = Factory::create('fr_FR');

        // Création d'un User
        $user = new User();

        $user->setEmail('user@test.com')
            ->setPrenom($faker->firstName())
            ->setNom($faker->lastName())
            ->setAPropos($faker->text())
            ->setLinkedin('linkedin')
            ->setGithub('github');

        $password = $this->encoder->encodePassword($user, 'password');
        $user->setPassword($password);

        $manager->persist($user);

        // Création de Catégories
        for ($k=0; $k < 3; $k++) {
            $categorie = new Categorie();

            $categorie->setName($faker->words(3, true));

            $manager->persist($categorie);
        }

        // Création de Projets
        for ($i=0; $i < 3; $i++) {
            $projet = new Projet();

            $projet->setName($faker->words(3, true))
                ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'))
                ->setDescription($faker->text(300))
                ->setPortfolio($faker->randomElement([true, false]))
                ->setFile('public/assets/media/images/mockup-construction.png')
                ->addCategorie($categorie)
                ->setUser($user);

            $manager->persist($projet);
        }

        $manager->flush();
    }
}
