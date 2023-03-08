<?php

namespace Application\Services;

use PHPUnit\Framework\TestCase;
use Temperworks\Codechallenge\Application\Domain\VehicleAlreadyInParkingException;
use Temperworks\Codechallenge\Application\Dto\VehicleDtoRequest;
use Temperworks\Codechallenge\Application\Services\ParkVehicle;

class ParkVehicleTest extends TestCase
{
    /** @test */
    public function cannotParkVehicle()
    {
        $vehicleDtoRequest = new VehicleDtoRequest("B1213BV");

        $this->expectException(VehicleAlreadyInParkingException::class);

        $mockParkVehicle = $this->createMock(ParkVehicle::class);

        $mockParkVehicle->method("parkVehicle")->willThrowException(new VehicleAlreadyInParkingException());
        $mockParkVehicle->parkVehicle($vehicleDtoRequest);
    }

    /** @test */
    public function canParkVehicle()
    {
        $vehicleDtoRequest = new VehicleDtoRequest("B1213BV");

        $mockParkVehicle = $this->createMock(ParkVehicle::class);

        $mockParkVehicle->method("parkVehicle")->willReturn(true);
        $this->assertTrue($mockParkVehicle->parkVehicle($vehicleDtoRequest));
    }
}
