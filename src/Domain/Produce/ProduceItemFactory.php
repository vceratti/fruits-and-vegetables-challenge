<?php

declare(strict_types=1);

namespace App\Domain\Produce;

use App\Service\ProduceItemDTO;
use InvalidArgumentException;

final class ProduceItemFactory
{
    /** @var iterable<ProduceItemCreationStrategyInterface> */
    private iterable $strategies;

    /** @param iterable<ProduceItemCreationStrategyInterface> $strategies */
    public function __construct(iterable $strategies)
    {
        $this->strategies = $strategies;
    }

    public function createFromDTO(ProduceItemDTO $dto): ProduceItemInterface
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($dto)) {
                return $strategy->create($dto);
            }
        }
        throw new InvalidArgumentException("Unknown produce item type: {$dto->getType()}");
    }
}
