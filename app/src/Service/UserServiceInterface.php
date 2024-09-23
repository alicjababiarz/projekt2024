<?php

/**
 * User service interface.
 */

namespace App\Service;

use App\Entity\User;

/**
 * User service interface.
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

    /**
     * @param User $user
     * @param string $newPassword
     * @return void
     */
    public function changePassword(User $user, string $newPassword): void;
}
