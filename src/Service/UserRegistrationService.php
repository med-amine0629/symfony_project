<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegistrationService
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
        private EntityManagerInterface $entityManager,
    )
    {
    }
    public function register(User $user , string $password)
    {
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
