<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\ByteString;

use App\Entity\Transaction;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User('admin@tcm.com');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);


        for ($j = 0; $j < 5; $j++) 
            {
                $transaction = new Transaction();
                $transaction->setAmount(rand(1000, 10000));
                $transaction->setPaymentLabel(ByteString::fromRandom(8, implode('', range('A', 'Z')))->toString());
                $transaction->setLocation($transaction->getLocations()[rand(0,9)]);
                $transaction->setCreatedAt(new \DateTime());
                $transaction->setUser($admin);
                $manager->persist($transaction);
                $admin->addTransaction($transaction);
            }

       
        $user = new User( 'user@tcm.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'user'));
            for ($j = 0; $j < 5; $j++) 
            {
                $transaction = new Transaction();
                $transaction->setAmount(rand(1000, 10000));
                $transaction->setPaymentLabel(ByteString::fromRandom(8, implode('', range('A', 'Z')))->toString());
                $transaction->setLocation($transaction->getLocations()[rand(0,9)]);
                $transaction->setCreatedAt(new \DateTime());
                $transaction->setUser($user);
                $manager->persist($transaction);
                $user->addTransaction($transaction);
            }
        $manager->persist($user);
        
        $manager->flush();
    }



}
