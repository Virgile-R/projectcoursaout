<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setLastName('TestLastName');
        $user->setFirstName('TestFirstName');
        $user->setEmail('test@test.com');
        $password = $this->hasher->hashPassword($user, 'Abcde123!');
        $user->setPassword($password);
        $manager->persist($user);

        $manager->flush();
    }
}
