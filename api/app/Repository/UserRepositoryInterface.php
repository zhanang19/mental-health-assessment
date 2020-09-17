<?php

namespace App\Repository;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    /**
     * Update user avatar.
     *
     * @param int $userId
     * @param string $base64
     * @return bool
     */
    public function updateAvatar(int $userId, string $base64): bool;

    /**
     * Find user by username.
     *
     * @param string $username
     * @return User
     */
    public function findByUsername(string $username): ?User;

    /**
     * Find user by email.
     *
     * @param string $email
     * @return User
     */
    public function findByEmail(string $email): ?User;

    /**
     * Find user by id.
     *
     * @param int $userId
     * @param string|array
     * @return User
     */
    public function findUserById(int $userId, $relations = ['activities']): ?User;

    /**
     * Get all user with role student.
     *
     * @return Collection
     */
    public function getStudents(): Collection;
}
