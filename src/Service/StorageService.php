<?php

declare(strict_types=1);

namespace App\Service;

use App\Domain\Produce\ProduceItemCollectionFactory;
use App\Repository\ProduceRepositoryInterface;
use JsonException;
use PHPUnit\Event\RuntimeException;
use Throwable;

readonly class StorageService
{
    public function __construct(
        private JsonFileReader               $fileReader,
        private ProduceRepositoryInterface   $produceRepository,
        private ProduceItemDTOFactory        $produceItemDTOFactory,
        private ProduceItemCollectionFactory $produceItemCollectionFactory,
    ) {

    }

    /** @throws JsonException|RuntimeException|Throwable */
    public function import(string $filePath): void
    {
        $data = $this->fileReader->read($filePath);
        $prodiceItemDtoCollection = $this->parseEntries($data);

        $collection = $this->produceItemCollectionFactory->createFromDTOArray($prodiceItemDtoCollection);

        $this->produceRepository->saveCollection($collection);
    }

    /**
     * @param array<int, mixed> $data
     * @return array<int, ProduceItemDTO>
     */
    private function parseEntries(array $data): array
    {
        $items = [];
        foreach ($data as $item) {
            $items[] = $this->produceItemDTOFactory->createFromArray($item);
        }

        return $items;
    }
}
