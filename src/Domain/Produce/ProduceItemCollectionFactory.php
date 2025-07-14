<?php

declare(strict_types=1);

namespace App\Domain\Produce;

use App\Service\ProduceItemDTO;

final readonly class ProduceItemCollectionFactory
{
    public function __construct(
        private ProduceItemFactory $produceItemFactory
    ) {
    }

    /** @param array<ProduceItemDTO> $items */
    public function createFromDTOArray(array $items): ProduceItemCollection
    {
        $collection = new ProduceItemCollection();

        foreach ($items as $item) {
            $item = $this->produceItemFactory->createFromDTO($item);
            $collection->add($item);
        }

        return $collection;
    }
}
