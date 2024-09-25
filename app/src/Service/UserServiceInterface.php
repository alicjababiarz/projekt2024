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
     * Find user by ID.
     *
     * @param int $id ID of the user
     */
    public function findUserById(int $id): ?User;

    /**
     * Saves the user entity.
     *
     * @param User $user Save user
     */
    public function saveUser(User $user): void;

    /**
     * Upgrades the password.
     *
     * @param User   $user           User entity
     * @param string $hashedPassword Set hashed password
     */
    public function upgradePassword(User $user, string $hashedPassword): void;

    /**
     * Changes the user's password.
     *
     * @param User   $user        User entity
     * @param string $newPassword Set new password
     */
    public function changePassword(User $user, string $newPassword): void;
}
