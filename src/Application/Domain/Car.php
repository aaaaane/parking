<?php

namespace Temperworks\Codechallenge\Application\Domain;

class Car extends Vehicle
{
    public static function fromDto(string $licensePlate): self
    {
        return new self(licensePlate: new LicensePlate($licensePlate));
    }
}
