<?php

declare(strict_types=1);

namespace App\Exception;

class DataNotFoundException extends \Exception
{
    public static function create(string $source, string $id): self
    {
        return new self(sprintf('The data is not found for: "%s #%s"', $source, $id));
    }
}
