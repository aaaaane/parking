<?php

namespace Temperworks\Codechallenge\Adapters\Controllers\DataValidators;

use Exception;

interface DataValidator
{
    /**
     * @throws Exception
     */
    public function validateData(): void;
}
