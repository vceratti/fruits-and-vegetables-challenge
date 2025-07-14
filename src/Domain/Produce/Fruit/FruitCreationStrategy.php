<?php

declare(strict_types=1);

namespace App\Domain\Produce\Fruit;

use App\Domain\Produce\ProduceItemCreationStrategyInterface;
use App\Domain\Produce\ProduceItemInterface;
use App\Service\ProduceItemDTO;

final class FruitCreationStrategy implements ProduceItemCreationStrategyInterface
{
    public function supports(ProduceItemDTO $dto): bool
    {
        return $dto->getType() === ProduceItemDTO::TYPE_FRUIT;
    }

    public function create(ProduceItemDTO $dto): ProduceItemInterface
    {
        return new Fruit(
            $dto->getId(),
            $dto->getName(),
            $dto->getQuantityInGrams(),
        );
    }
}
