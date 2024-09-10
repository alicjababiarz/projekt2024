<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 *
 */
class UserService implements UserServiceInterface
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function findUserById(int $id): ?User
    {
        return $this->entityManager->getRepository(User::class)->find($id);
    }

    /**
     * @param User $user
     * @return void
     */
    public function saveUser(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @param User $user
     * @param string $hashedPassword
     * @return void
     */
    public function upgradePassword(User $user, string $hashedPassword): void
    {
        $user->setPassword($hashedPassword);
        $this->saveUser($user);
    }
}