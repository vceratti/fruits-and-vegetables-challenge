<?php

declare(strict_types=1);

namespace Tests\Service;

use App\Domain\Produce\ProduceItemCollectionFactory;
use App\Service\StorageService;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use JsonException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use Tests\IntegrationTestCase;
use Throwable;

#[CoversClass(StorageService::class)]
#[CoversClass(ProduceItemCollectionFactory::class)]
#[Group('integration')]
class StorageServiceTest extends IntegrationTestCase
{
    private StorageService $storageService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->storageService = $this->getFromContainer(StorageService::class);
    }

    /** @throws JsonException|Exception|Throwable */
    public function testImportSuccessfully(): void
    {
        $this->storageService->import(__DIR__ . '/../../request.json');

        $result = $this->getFromContainer(Connection::class)
            ->executeQuery('SELECT * FROM produce')
            ->fetchAllAssociative();

        $this->assertCount(20, $result);

        $firstVegetable = $result[0];
        $this->assertSame('Carrot', $firstVegetable['name']);
        $this->assertSame(10922, $firstVegetable['quantity']);
        $this->assertSame('vegetable', $firstVegetable['type']);

        $firstFruit = $result[1];
        $this->assertSame('Apples', $firstFruit['name']);
        $this->assertSame(20000, $firstFruit['quantity']);
        $this->assertSame('fruit', $firstFruit['type']);
    }
}
