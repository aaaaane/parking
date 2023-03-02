<?php

namespace Temperworks\Codechallenge\Application\Domain;

abstract class Vehicle
{
    public function __construct(private LicensePlate $licensePlate)
    {
    }

    public function licensePlate(): LicensePlate
    {
        return $this->licensePlate;
    }

    public function isVehicleInParking(array $vehiclesParked): bool
    {
        foreach ($vehiclesParked as $vehicleParked) {
            if ($this->licensePlate()->__toString() === $vehicleParked->licensePlate()->licensePlate()) {
                return true;
            }
        }

        return false;
    }

    abstract public static function fromDto(string $licensePlate): self;
}
