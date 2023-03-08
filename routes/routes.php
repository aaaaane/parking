<?php

use DevCoder\Route;
use DevCoder\Router;
use Temperworks\Codechallenge\Adapters\Controllers\ParkingController;

$routes = [
    new  Route('park_vehicle', '/api/park/{license_plate}', [ParkingController::class, 'parkVehicle'], ['POST']),
    new  Route('unpark_vehicle', '/api/unpark/{license_plate}', [ParkingController::class, 'unparkVehicle'], ['POST']),
];

