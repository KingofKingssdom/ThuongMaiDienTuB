<?php

namespace App\Services\Interfaces;

interface SpecificationValueServiceInterface
{
    public function addAsync(array $request): mixed;
    public function getByIdAsync(int $id): mixed;
    public function getAllAsync(): mixed;
}