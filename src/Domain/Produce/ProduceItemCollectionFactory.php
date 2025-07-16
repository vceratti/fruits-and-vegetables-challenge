<?php

declare(strict_types=1);

namespace App\Domain\Produce;

use App\Service\ProduceItemDTO;

final readonly class ProduceItemCollectionFactory
{
    private const string DEFAULT_QUANTITY_UNIT = 'g';

    public function __construct(
        private ProduceItemFactory $produceItemFactory
    ) {
    }

    /**
     * @param array<ProduceItemDTO> $dtoItems
     * @return ProduceItemCollection<ProduceItemInterface>
     */
    public function createFromDTOArray(array $dtoItems): ProduceItemCollection
    {
        $collection = new ProduceItemCollection();

        foreach ($dtoItems as $dtoItem) {
            $item = $this->produceItemFactory->createFromDTO($dtoItem);
            $collection->add($item);
        }

        return $collection;
    }

    /**
     * @param array<int, array<string, mixed>> $dbData
     * @return ProduceItemCollection<ProduceItemInterface>
     */
    public function createFromDB(array $dbData): ProduceItemCollection
    {
        $collection = new ProduceItemCollection();

        foreach ($dbData as $row) {
            $produceItem = new ProduceItemDTO(
                $row['id'],
                $row['name'],
                $row['type'],
                (int)$row['quantity'],
                self::DEFAULT_QUANTITY_UNIT
            );
            $item = $this->produceItemFactory->createFromDTO($produceItem);
            $collection->add($item);
        }

        return $collection;
    }
}
