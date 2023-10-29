<?php

declare(strict_types=1);

namespace App\Dto;

class ErrorDto
{
    public function __construct(public readonly int $cod, public readonly string $message)
    {
    }
}
