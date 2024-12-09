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
        $user = new User('admin@tcm.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'admin'));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);


        for ($i = 0; $i < 5; $i++) 
            {
                $transaction = new Transaction();
                $transaction->setAmount(rand(1000, 10000));
                $transaction->setPaymentLabel(ByteString::fromRandom(8, implode('', range('A', 'Z')))->toString());
                $transaction->setLocation($transaction->getLocations()[rand(0,9)]);
                $transaction->setCreatedAt(new \DateTime());
                $transaction->setCreatedBy($user);
                $manager->persist($transaction);
            }

        // create 10 users!
        for ($i = 0; $i < 5; $i++) {
            $unique_email = ByteString::fromRandom(6)->toString() . '@tcm.com';
            $user = new User( $unique_email);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));


            for ($j = 0; $j < 5; $j++) 
            {
                $transaction = new Transaction();
                $transaction->setAmount(rand(1000, 10000));
                $transaction->setPaymentLabel(ByteString::fromRandom(8, implode('', range('A', 'Z')))->toString());
                $transaction->setLocation($transaction->getLocations()[rand(0,9)]);
                $transaction->setCreatedAt(new \DateTime());
                $transaction->setCreatedBy($user);
                $manager->persist($transaction);
            }


            $manager->persist($user);
        }
        $manager->flush();
    }



}
