<?php

declare(strict_types=1);

namespace App\Repository\Mysql;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;

final class UserRepositoryFactory
{
    public function __construct(readonly private string $dsn)
    {
    }

    public function create(): UserRepository
    {
        $parsedDns = (new DsnParser())->parse($this->dsn);
        $connection = DriverManager::getConnection($parsedDns);

        return new UserRepository($connection);
    }
}
