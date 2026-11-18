<?php

namespace App\Services\Interfaces;

interface SpecificationGroupServiceInterface
{
    public function addAsync(array $request): mixed;
    public function getByIdAsync(int $id): mixed;
    public function getAllAsync(): mixed;
}