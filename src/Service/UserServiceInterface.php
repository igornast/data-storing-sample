<?php

namespace App\Service;

use App\Entity\User;

interface UserServiceInterface
{
    public function create(string $name): void;

    public function find(string $id): User;
}
