<?php

namespace Temperworks\Codechallenge\Application\Dto;

class VehicleDtoRequest
{
    public function __construct(private readonly string $licensePlate)
    {
    }

    public function licensePlate(): string
    {
        return $this->licensePlate;
    }
}
