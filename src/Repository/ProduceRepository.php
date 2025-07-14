<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Produce\ProduceItemCollection;
use Doctrine\DBAL\Connection;
use Throwable;

final readonly class ProduceRepository implements ProduceRepositoryInterface
{
    public function __construct(private Connection $connection)
    {
    }

    /** @throws Throwable */
    public function saveCollection(ProduceItemCollection $itemCollection): void
    {

        try {
            $this->connection->beginTransaction();

            $queryBuilder = $this->connection->createQueryBuilder();

            $queryBuilder
                ->insert('produce')
                ->values([
                    'id' => ':id',
                    'name' => ':name',
                    'type' => ':type',
                    'quantity' => ':quantity',
                ]);

            $stmt = $queryBuilder->getSQL();
            $statement = $this->connection->prepare($stmt);

            foreach ($itemCollection as $item) {
                $statement->executeStatement([
                    'id' => $item->getId(),
                    'name' => $item->getName(),
                    'type' => $item->getType(),
                    'quantity' => $item->getQuantity(),
                ]);
            }

            $this->connection->commit();
        } catch (Throwable $throwable) {
            $this->connection->rollBack();
            throw $throwable;
        }
    }
}
