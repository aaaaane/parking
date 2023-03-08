<?php

namespace Temperworks\Codechallenge\Application\Domain;

class Level
{
    public function __construct(private int $availableSlots = 10)
    {
    }

    public function availableSlots(): int
    {
        return $this->availableSlots;
    }

    public function updateAvailableSlots(int $availableSlots)
    {
        $this->availableSlots = $availableSlots;
    }
}
