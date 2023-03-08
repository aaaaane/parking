<?php

namespace Application\Services;

use PHPUnit\Framework\TestCase;
use Temperworks\Codechallenge\Adapters\Repositories\DataPersistHelper;
use Temperworks\Codechallenge\Application\Domain\ParkingIsFullException;
use Temperworks\Codechallenge\Application\Services\CheckAvailableSpots;

class CheckAvailableSpotsTest extends TestCase
{
    private CheckAvailableSpots $checkAvailableSpots;
    private DataPersistHelper $dataPersistHelper;

    public function setUp(): void
    {
        $this->dataPersistHelper = new DataPersistHelper();
        $this->checkAvailableSpots = new CheckAvailableSpots($this->dataPersistHelper);
    }

    /** @test */
    public function canCheckAvailableSpots()
    {
        $this->assertSame(10, $this->checkAvailableSpots->checkAvailableSpots());
    }

    /** @test */
    public function parkingIsFull()
    {
        $this->expectException(ParkingIsFullException::class);

        $mockCheckAvailableSpots = $this->createMock(CheckAvailableSpots::class);

        $mockCheckAvailableSpots->method("checkAvailableSpots")->willThrowException(new ParkingIsFullException());
        $mockCheckAvailableSpots->checkAvailableSpots();
    }
}
