<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService implements UserServiceInterface
{
    public function __construct(
        readonly private UserRepositoryInterface $userRepository,
        readonly private ValidatorInterface $validator,
    ) {
    }

    public function create(string $name): void
    {
        $user = new User((string) Uuid::v4(), $name);
        $errors = $this->validator->validate($user);

        if (\count($errors) > 0) {
            throw new \InvalidArgumentException('Invalid User object provided.');
        }

        $this->userRepository->save($user);
    }

    public function find(string $id): User
    {
        $data = $this->userRepository->find($id);

        return new User(id: $data['id'], name: $data['name']);
    }
}
