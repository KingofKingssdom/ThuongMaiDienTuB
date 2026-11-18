<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\SpecificationValueRepositoryInterface;
use App\Services\Interfaces\SpecificationValueServiceInterface;
use App\Http\Resources\SpecificationValueResource;

class SpecificationValueService implements SpecificationValueServiceInterface
{
    protected SpecificationValueRepositoryInterface $specificationValueRepository;

    public function __construct(SpecificationValueRepositoryInterface $specificationValueRepository)
    {
        $this->specificationValueRepository = $specificationValueRepository;
    }

    public function addAsync(array $request): mixed
    {
        $specificationValue = $this->specificationValueRepository->addAsync([
            'value'                      => $request['Value'] ?? $request['value'] ?? '',
            'product_id'                 => $request['ProductId'] ?? $request['product_id'] ?? 0,
            'specification_attribute_id' => $request['SpecificationAttributeId'] ?? $request['specification_attribute_id'] ?? 0,
        ]);

        return new SpecificationValueResource($specificationValue);
    }

    public function getByIdAsync(int $id): mixed
    {
        $specificationValueExisting = $this->specificationValueRepository->getByIdAsync($id);
        if (!$specificationValueExisting) {
            return null;
        }

        return new SpecificationValueResource($specificationValueExisting);
    }

    public function getAllAsync(): mixed
    {
        $values = $this->specificationValueRepository->getAllAsync();
        if ($values->isEmpty()) {
            return null;
        }

        return SpecificationValueResource::collection($values);
    }
}