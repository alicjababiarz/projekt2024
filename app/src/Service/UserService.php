<?php

/**
 * User interface.
 */

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * User service.
 */
class UserService implements UserServiceInterface
{
    public UserPasswordHasherInterface $passwordHasher;

    /**
     * @param EntityManagerInterface      $entityManager  Entity manager
     * @param UserPasswordHasherInterface $passwordHasher Password hasher
     */
    public function __construct(private readonly EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @param int $id Id
     *
     * @return User|null User
     */
    public function findUserById(int $id): ?User
    {
        return $this->entityManager->getRepository(User::class)->find($id);
    }

    /**
     * @param User $user User
     */
    public function saveUser(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @param User   $user           User
     * @param string $hashedPassword Hashed Password
     */
    public function upgradePassword(User $user, string $hashedPassword): void
    {
        $user->setPassword($hashedPassword);
        $this->saveUser($user);
    }

    /**
     * @param User   $user        User
     * @param string $newPassword New Password
     */
    public function changePassword(User $user, string $newPassword): void
    {
        $hashedPassword = $this->passwordHasher->hashPassword($user, $newPassword);
        $this->upgradePassword($user, $hashedPassword);
    }
}
