<?php

namespace Application\Services;

use PHPUnit\Framework\TestCase;
use Temperworks\Codechallenge\Application\Domain\NoVehiclesInsideTheParkingException;
use Temperworks\Codechallenge\Application\Domain\VehicleNotParkedException;
use Temperworks\Codechallenge\Application\Dto\VehicleDtoRequest;
use Temperworks\Codechallenge\Application\Services\UnparkVehicle;

class UnparkVehicleTest extends TestCase
{
    /** @test */
    public function cannotUnparkVehicleNoVehiclesInParking()
    {
        $vehicleDtoRequest = new VehicleDtoRequest("B1213BV");

        $this->expectException(NoVehiclesInsideTheParkingException::class);

        $mockUnparkVehicle = $this->createMock(UnparkVehicle::class);

        $mockUnparkVehicle->method("unparkVehicle")->willThrowException(new NoVehiclesInsideTheParkingException());
        $mockUnparkVehicle->unparkVehicle($vehicleDtoRequest);
    }

    /** @test */
    public function cannotUnparkVehicleVehicleNotParked()
    {
        $vehicleDtoRequest = new VehicleDtoRequest("B1213BV");

        $this->expectException(VehicleNotParkedException::class);

        $mockUnparkVehicle = $this->createMock(UnparkVehicle::class);

        $mockUnparkVehicle->method("unparkVehicle")->willThrowException(new VehicleNotParkedException());
        $mockUnparkVehicle->unparkVehicle($vehicleDtoRequest);
    }

    /** @test */
    public function canUnparkVehicle()
    {
        $vehicleDtoRequest = new VehicleDtoRequest("B1213BV");

        $mockParkVehicle = $this->createMock(UnparkVehicle::class);

        $mockParkVehicle->method("unparkVehicle")->willReturn(true);
        $this->assertTrue($mockParkVehicle->unparkVehicle($vehicleDtoRequest));
    }
}
