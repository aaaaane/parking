<?php

namespace Temperworks\Codechallenge\Adapters\Repositories;

use Temperworks\Codechallenge\Application\Domain\Level;
use Temperworks\Codechallenge\Application\Domain\NoVehiclesInsideTheParkingException;
use Temperworks\Codechallenge\Application\Domain\Parking;
use Temperworks\Codechallenge\Application\Domain\Vehicle;
use Temperworks\Codechallenge\Application\Domain\VehicleAlreadyInParkingException;
use Temperworks\Codechallenge\Application\Domain\VehicleNotParkedException;

class DataPersistHelper
{
    private const VEHICLES_INSIDE = "vehicles_inside";
    private const PARKING = "parking";

    public function __constructor()
    {
    }

    public function getVehiclesInside(): array
    {
        $vehicles = apcu_fetch($this::VEHICLES_INSIDE);
        if ($vehicles !== false) {
            return $vehicles;
        }

        return [];
    }

    public function parkVehicle(Vehicle $vehicle, Parking $parking): bool
    {
        $vehiclesInside = $this->getVehiclesInside();

        if ($vehicle->isVehicleInParking($vehiclesInside)) {
            throw new VehicleAlreadyInParkingException("This vehicle is already parked here.");
        }

        array_push($vehiclesInside, $vehicle);

        apcu_store($this::VEHICLES_INSIDE, $vehiclesInside);

        $parking->level()->updateAvailableSlots($parking->level()->availableSlots() - 1);

        return $this->storeParking($parking);
    }

    public function unparkVehicle(Vehicle $vehicle, Parking $parking): bool
    {
        $vehiclesInside = $this->getVehiclesInside();

        if ($vehiclesInside === []) {
            throw new NoVehiclesInsideTheParkingException("There are no vehicles parked.");
        }

        if (!$vehicle->isVehicleInParking($vehiclesInside)) {
            throw new VehicleNotParkedException("This vehicle is not parked here.");
        }

        $newVehiclesInside = [];

        foreach ($vehiclesInside as $vehicleInside) {
            if ($vehicle->licensePlate()->__toString() !== $vehicleInside->licensePlate()->licensePlate()) {
                $newVehiclesInside[] = $vehicleInside;
            }
        }

        apcu_store($this::VEHICLES_INSIDE, $newVehiclesInside);

        $parking->level()->updateAvailableSlots($parking->level()->availableSlots() + 1);

        return $this->storeParking($parking);
    }

    public function getParking(): Parking
    {
        $parking = apcu_fetch($this::PARKING);

        if ($parking !== false) {
            return $parking;
        }

        $parking = new Parking(level: new Level());
        $this->storeParking($parking);

        return $parking;
    }

    public function storeParking(Parking $parking): bool
    {
        return apcu_store($this::PARKING, $parking);
    }
}
