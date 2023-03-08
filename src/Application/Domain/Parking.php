<?php

namespace Temperworks\Codechallenge\Application\Domain;

class Parking
{
    /* Here I assume that the parking will only have one level, for making it with multiple levels we have to change the type
     * of level to an array of levels
     */
    public function __construct(private Level $level)
    {
    }

    public function level(): level
    {
        return $this->level;
    }
}
