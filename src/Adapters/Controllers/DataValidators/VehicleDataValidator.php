<?php

namespace Temperworks\Codechallenge\Adapters\Controllers\DataValidators;

use Exception;

class VehicleDataValidator implements DataValidator
{
    /**
     * @throws Exception
     */
    public function validateData(string $licensePlate = null): void
    {
        if ($licensePlate === null || gettype($licensePlate) !== "string") {
            throw new Exception("License plate is mandatory");
        }
    }
}
