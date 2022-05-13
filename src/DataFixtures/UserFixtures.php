<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;


class UserFixtures extends Fixture
{

    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $roles = ["ROLE_PARENT", "ROLE_SCHOOL"];
        $faker = Factory::create("fr_FR");
        // $name = strtolower($faker->lastName());
        //     $email = $name."@gmail.com";
        //     $password = $name."123";
        //     $role = $roles[$faker->numberBetween(0, 1)];
        // $user = new User();
        // $user->setEmail($email)
        //     ->setRoles([$role])
        //     ->setPassword($this->passwordHasher->hashPassword($user, $password));
        // $manager->persist($user);

        
        for ($i=0; $i < 4; $i++) { 
            $name = strtolower($faker->lastName());
            $email = $name."@gmail.com";
            $password = $name."123";
            $role = $roles[$faker->numberBetween(0, 1)];
        $user = new User();
        $user->setEmail($email)
            ->setRoles([$role])
            ->setPassword($this->passwordHasher->hashPassword($user, $password));
        $manager->persist($user);
        }

        $manager->flush();
     
    }
}
