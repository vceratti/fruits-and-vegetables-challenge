<?php

declare(strict_types=1);

namespace App\Domain\Produce\Vegetable;

use App\Domain\Produce\ProduceItemCreationStrategyInterface;
use App\Domain\Produce\ProduceItemInterface;
use App\Service\ProduceItemDTO;

final class VegetableCreationStrategy implements ProduceItemCreationStrategyInterface
{
    public function supports(ProduceItemDTO $dto): bool
    {
        return $dto->getType() === ProduceItemDTO::TYPE_VEGETABLE;
    }

    public function create(ProduceItemDTO $dto): ProduceItemInterface
    {
        return new Vegetable(
            $dto->getId(),
            $dto->getName(),
            $dto->getQuantityInGrams(),
        );
    }
}
