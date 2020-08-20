<?php

namespace App\Repository\Eloquent;

use App\Repository\UserRepositoryInterface;
use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Operation $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Find user by id.
     *
     * @param int $userId
     * @param array|string $relations
     * @return User
     */
    public function findUserById(int $userId, $relations = ['activities']): ?User
    {
        return $this->model->with($relations)->findOrFail($userId);
    }

    /**
     * Find user by username.
     *
     * @param string $username
     * @return User
     */
    public function findByUsername(string $username): ?User
    {
        return $this->model->firstWhere('username', $username);
    }

    /**
     * Find user by email.
     *
     * @param string $email
     * @return User
     */
    public function findByEmail(string $email): ?User
    {
        return $this->model->firstWhere('email', $email);
    }

    /**
     * Create a user.
     *
     * @param array $payload
     * @return User
     */
    public function create(array $payload): ?User
    {
        $user = $this->model->create(
            Arr::except($payload, [
                'role',
                'avatar'
            ])
        );

        $avatarBase64 = Arr::get($payload, 'avatar');

        if ($avatarBase64) {
            $this->updateAvatar($user->id, $avatarBase64);
        }

        $user->fresh();

        $user->assignRole($payload['role']);

        return $user;
    }

    /**
     * Update existing model.
     *
     * @param int $userId
     * @param array $payload
     * @return bool
     */
    public function update(int $userId, array $payload): bool
    {
        $user = $this->findById($userId);

        $user->syncRoles(Arr::get($payload, 'role'));

        $user->fill(
            Arr::except($payload, ['activities', 'role', 'avatar'])
        );

        if (!$user->saveOrFail()) {
            return false;
        }

        $user->fresh();

        return true;
    }

    /**
     * Update user avatar.
     *
     * @param int $userId
     * @param string $base64
     * @return bool
     */
    public function updateAvatar(int $userId, string $base64): bool
    {
        $user = $this->findById($userId);
        $file = null;

        if (isNotEmpty($base64)) {
            $user->clearMediaCollection('avatar');

            $file = $user->addMediaFromBase64(
                $base64
            )->toMediaCollection('avatar');
        }

        return $file != null;
    }
}
