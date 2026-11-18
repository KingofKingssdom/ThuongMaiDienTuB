<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\SpecificationGroupRepositoryInterface;
use App\Services\Interfaces\SpecificationGroupServiceInterface;
use App\Http\Resources\SpecificationGroupResource;

class SpecificationGroupService implements SpecificationGroupServiceInterface
{
    protected SpecificationGroupRepositoryInterface $specificationGroupRepository;

    public function __construct(SpecificationGroupRepositoryInterface $specificationGroupRepository)
    {
        $this->specificationGroupRepository = $specificationGroupRepository;
    }

    public function addAsync(array $request): mixed
    {
        $specificationGroup = $this->specificationGroupRepository->addAsync([
            'specification_name' => $request['SpecificationName'] ?? $request['specification_name'] ?? '',
            'category_id'        => $request['CategoryId'] ?? $request['category_id'] ?? 0,
        ]);

        return new SpecificationGroupResource($specificationGroup->load('category'));
    }

    public function getByIdAsync(int $id): mixed
    {
        $specificationGroupExisting = $this->specificationGroupRepository->getById($id);
        if (!$specificationGroupExisting) {
            return null;
        }

        return new SpecificationGroupResource($specificationGroupExisting->load('category'));
    }

    public function getAllAsync(): mixed
    {
        $groups = $this->specificationGroupRepository->getAllAsync();
        if ($groups->isEmpty()) {
            return null;
        }

        return SpecificationGroupResource::collection($groups);
    }
}