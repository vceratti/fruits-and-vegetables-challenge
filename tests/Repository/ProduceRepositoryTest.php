<?php

declare(strict_types=1);

namespace Tests\Repository;

use App\Domain\Produce\Fruit\Fruit;
use App\Domain\Produce\ProduceItem;
use App\Domain\Produce\ProduceItemCollection;
use App\Domain\Produce\Vegetable\Vegetable;
use App\Repository\ProduceRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\DriverException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use Tests\IntegrationTestCase;
use Throwable;

#[CoversClass(ProduceRepository::class)]
#[CoversClass(ProduceItemCollection::class)]
#[CoversClass(ProduceItem::class)]
#[Group('integration')]
class ProduceRepositoryTest extends IntegrationTestCase
{
    private ProduceRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->getFromContainer(ProduceRepository::class);
    }

    /** @throws Exception|Throwable */
    public function testImportSuccessfully(): void
    {
        $collection = new ProduceItemCollection();
        $fruit1 = new Fruit(1, 'Apples', 20000);
        $fruit2 = new Fruit(2, 'Oranges', 20);
        $vegetable1 = new Vegetable(3, 'Carrot', 10922);
        $collection->add($fruit1);
        $collection->add($fruit2);
        $collection->add($vegetable1);

        $this->repository->saveCollection($collection);

        $result = $this->getFromContainer(Connection::class)
            ->executeQuery('SELECT * FROM produce')
            ->fetchAllAssociative();

        $this->assertCount(3, $result);
    }

    /** @throws Exception|Throwable */
    public function testUniqueId(): void
    {
        $collection = new ProduceItemCollection();
        $fruit1 = new Fruit(1, 'Apples', 20000);
        $fruit2 = new Fruit(1, 'Oranges', 20);
        $collection->add($fruit1);
        $collection->add($fruit2);

        $this->expectException(UniqueConstraintViolationException::class);
        $this->repository->saveCollection($collection);
    }

    /** @throws Exception|Throwable */
    public function testCantSaveInvalidProduceClass(): void
    {
        $collection = new ProduceItemCollection();
        $fruit1 = new Fruit(1, 'Apples', 20000);
        $collection->add($fruit1);

        $beansObject = new InvalidProduceType(2, 'Beans', 1000);
        $collection->add($beansObject);

        $this->expectException(DriverException::class);
        $this->repository->saveCollection($collection);
    }
}
