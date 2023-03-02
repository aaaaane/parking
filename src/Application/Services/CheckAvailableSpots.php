<?php

namespace Temperworks\Codechallenge\Application\Services;

use Temperworks\Codechallenge\Adapters\Repositories\DataPersistHelper;
use Temperworks\Codechallenge\Application\Domain\ParkingIsFullException;

class CheckAvailableSpots
{
    public function __construct(private DataPersistHelper $dataPersistHelper)
    {
    }

    public function checkAvailableSpots(): int
    {
        $parking = $this->dataPersistHelper->getParking();
        $availableSpots = $parking->level()->availableSlots();

        if ($availableSpots === 0) {
            throw new ParkingIsFullException("Sorry, no place left.");
        }

        return $availableSpots;
    }
}
