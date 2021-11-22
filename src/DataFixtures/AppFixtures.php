<?php

namespace App\DataFixtures;

use App\Factory\AndesUserFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        UserFactory::createOne(['email' => 'abraca_admin@example.com']);

        UserFactory::createMany(10);
        AndesUserFactory::createOne([
            'email' => 'abraca_admin@example.com',
        ]);
        AndesUserFactory::createMany(10);

        $manager->flush();
    }
}
