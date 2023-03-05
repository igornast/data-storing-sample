<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

final class User
{
    public function __construct(
        #[
            Assert\NotBlank,
            Assert\Uuid
        ]
        readonly private string $id,
        #[
            Assert\NotBlank
        ]
        readonly private string $name
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
