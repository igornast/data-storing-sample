<?php

namespace App\Repository;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    /**
     * @return array<string, string>
     */
    public function find(string $id): array;
}
