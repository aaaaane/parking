<?php

namespace Temperworks\Codechallenge\Adapters\Controllers;

use Exception;
use Temperworks\Codechallenge\Adapters\Controllers\DataValidators\DataValidator;
use Temperworks\Codechallenge\Adapters\Controllers\DataValidators\VehicleDataValidator;
use Temperworks\Codechallenge\Adapters\Repositories\DataPersistHelper;
use Temperworks\Codechallenge\Application\Domain\ParkingIsFullException;
use Temperworks\Codechallenge\Application\Dto\VehicleDtoRequest;
use Temperworks\Codechallenge\Application\Services\CheckAvailableSpots;
use Temperworks\Codechallenge\Application\Services\ParkVehicle;
use Temperworks\Codechallenge\Application\Services\UnparkVehicle;

class ParkingController
{
    private DataValidator $dataValidator;
    private CheckAvailableSpots $checkAvailableSpots;
    private ParkVehicle $parkVehicle;
    private UnparkVehicle $unparkVehicle;

    public function __construct()
    {
        $dataPersistHelper = new DataPersistHelper();
        $this->dataValidator = new VehicleDataValidator();
        $this->checkAvailableSpots = new CheckAvailableSpots($dataPersistHelper);
        $this->parkVehicle = new ParkVehicle($dataPersistHelper);
        $this->unparkVehicle = new UnparkVehicle($dataPersistHelper);
    }

    public function parkVehicle(string $licensePlate): array
    {
        try {
            $this->dataValidator->validateData(licensePlate: $licensePlate);
        } catch (Exception $exception) {
            return [
                "status" => 400,
                "message" => $exception->getMessage()
            ];
        }

        $vehicleDtoRequest = new VehicleDtoRequest(licensePlate: $licensePlate);

        try {
            $this->checkAvailableSpots->checkAvailableSpots();

        } catch (ParkingIsFullException $parkingIsFullException) {
            return [
                "status" => 400,
                "message" => $parkingIsFullException->getMessage()
            ];
        }

        try {
            if ($this->parkVehicle->parkVehicle($vehicleDtoRequest) === false) {
                throw new Exception();
            }

        } catch (Exception $exception) {
            return [
                "status" => 400,
                "message" => $exception->getMessage()
            ];
        }

        return [
            "status" => 200,
            "message" => "Welcome, please go in. Parked vehicle with license plate " . $vehicleDtoRequest->licensePlate(),
        ];
    }

    public function unparkVehicle(string $licensePlate): array
    {
        $vehicleDtoRequest = new VehicleDtoRequest(licensePlate: $licensePlate);

        try {
            if ($this->unparkVehicle->unparkVehicle($vehicleDtoRequest) === false) {
                throw new Exception();
            }

        } catch (Exception $exception) {
            return [
                "status" => 400,
                "message" => $exception->getMessage()
            ];
        }

        return [
            "status" => 200,
            "message" => "Unparked vehicle with license plate " . $vehicleDtoRequest->licensePlate(),
        ];
    }
}
