<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\SpecificationAttributeRepositoryInterface;
use App\Services\Interfaces\SpecificationAttributeServiceInterface;
use App\Http\Resources\SpecificationAttributeResource;

class SpecificationAttributeService implements SpecificationAttributeServiceInterface
{
    protected SpecificationAttributeRepositoryInterface $specificationAttributeRepository;

    public function __construct(SpecificationAttributeRepositoryInterface $specificationAttributeRepository)
    {
        $this->specificationAttributeRepository = $specificationAttributeRepository;
    }

    public function addAsync(array $request): mixed
    {
        $specificationAttribute = $this->specificationAttributeRepository->addAsync([
            'label_specification'    => $request['LabelSpecification'] ?? $request['label_specification'] ?? '',
            'specification_group_id' => $request['SpecificationGroupId'] ?? $request['specification_group_id'] ?? 0,
        ]);

        return new SpecificationAttributeResource($specificationAttribute);
    }

    public function getByIdAsync(int $id): mixed
    {
        $specificationAttributeExisting = $this->specificationAttributeRepository->getByIdAsync($id);
        if (!$specificationAttributeExisting) {
            return null;
        }

        return new SpecificationAttributeResource($specificationAttributeExisting->load('specificationValues'));
    }

    public function getAllAsync(): mixed
    {
        $attributes = $this->specificationAttributeRepository->getAllAsync();
        if ($attributes->isEmpty()) {
            return null;
        }

        return SpecificationAttributeResource::collection($attributes);
    }
}