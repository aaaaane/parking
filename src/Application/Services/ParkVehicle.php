<?php

namespace Temperworks\Codechallenge\Application\Services;

use Exception;
use Temperworks\Codechallenge\Adapters\Repositories\DataPersistHelper;
use Temperworks\Codechallenge\Application\Domain\Car;
use Temperworks\Codechallenge\Application\Domain\VehicleAlreadyInParkingException;
use Temperworks\Codechallenge\Application\Dto\VehicleDtoRequest;

class ParkVehicle
{
    public function __construct(private DataPersistHelper $dataPersistHelper)
    {
    }

    /**
     * @throws VehicleAlreadyInParkingException
     */
    public function parkVehicle(VehicleDtoRequest $vehicleDtoRequest): bool
    {
        return $this->dataPersistHelper->parkVehicle(
            vehicle: Car::fromDto($vehicleDtoRequest->licensePlate()),
            parking: $this->dataPersistHelper->getParking()
        );
    }
}
