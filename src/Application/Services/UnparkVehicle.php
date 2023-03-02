<?php

namespace Temperworks\Codechallenge\Application\Services;

use Temperworks\Codechallenge\Adapters\Repositories\DataPersistHelper;
use Temperworks\Codechallenge\Application\Domain\Car;
use Temperworks\Codechallenge\Application\Domain\NoVehiclesInsideTheParkingException;
use Temperworks\Codechallenge\Application\Domain\VehicleNotParkedException;
use Temperworks\Codechallenge\Application\Dto\VehicleDtoRequest;

class UnparkVehicle
{
    public function __construct(private DataPersistHelper $dataPersistHelper)
    {
    }

    /**
     * @throws NoVehiclesInsideTheParkingException
     * @throws VehicleNotParkedException
     */
    public function unparkVehicle(VehicleDtoRequest $vehicleDtoRequest): bool
    {
        return $this->dataPersistHelper->unparkVehicle(
            vehicle: Car::fromDto($vehicleDtoRequest->licensePlate()),
            parking: $this->dataPersistHelper->getParking()
        );
    }
}
