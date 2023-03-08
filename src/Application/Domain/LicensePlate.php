<?php

namespace Temperworks\Codechallenge\Application\Domain;

class LicensePlate
{
    public function __construct(private readonly string $licensePlate)
    {
    }

    public function __toString(): string
    {
        return $this->licensePlate;
    }
}
