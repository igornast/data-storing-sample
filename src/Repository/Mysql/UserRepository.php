<?php

declare(strict_types=1);

namespace App\Repository\Mysql;

use App\Entity\User;
use App\Exception\DataNotFoundException;
use App\Repository\UserRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ParameterType;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(readonly private Connection $connection)
    {
    }

    public function save(User $user): void
    {
        $this->connection->executeStatement(
            'INSERT INTO user (id, name) VALUES (?, ?)',
            [$user->getId(), $user->getName()],
            [ParameterType::STRING, ParameterType::STRING]
        );
    }

    public function find(string $id): array
    {
        $stmt = $this->connection->executeQuery('SELECT * FROM user WHERE id = ?', [$id], [ParameterType::STRING]);
        $result = $stmt->fetchAssociative();

        if (false === $result) {
            throw DataNotFoundException::create(User::class, $id);
        }

        return $result;
    }
}
