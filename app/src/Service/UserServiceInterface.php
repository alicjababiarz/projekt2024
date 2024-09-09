<?php

namespace App\Service;

use App\Entity\User;

/**
 *
 */
interface UserServiceInterface
{
    /**
     * @param int $id
     * @return User|null
     */
    public function findUserById(int $id): ?User;

    /**
     * @param User $user
     * @return void
     */
    public function saveUser(User $user): void;

    /**
     * @param User $user
     * @param string $hashedPassword
     * @return void
     */
    public function upgradePassword(User $user, string $hashedPassword): void;
}
