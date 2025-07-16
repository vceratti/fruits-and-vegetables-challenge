<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Produce\ProduceItemCollection;
use App\Domain\Produce\ProduceItemCollectionFactory;
use App\Domain\Produce\ProduceItemInterface;
use App\Service\ProduceItemDTO;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Throwable;

readonly class ProduceRepository implements ProduceRepositoryInterface
{
    public function __construct(
        private Connection                     $connection,
        protected ProduceItemCollectionFactory $produceItemCollectionFactory
    ) {
    }

    /**
     * @param ProduceItemCollection<ProduceItemInterface> $itemCollection
     * @throws Throwable
     */
    public function saveCollection(ProduceItemCollection $itemCollection): void
    {
        try {
            $this->connection->beginTransaction();

            foreach ($itemCollection as $item) {
                $this->saveProduce($item);
            }

            $this->connection->commit();
        } catch (Throwable $throwable) {
            $this->connection->rollBack();
            throw $throwable;
        }
    }

    /** @throws Exception|Throwable */
    public function saveProduce(ProduceItemInterface $entity): void
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

            $statement->executeStatement([
                'id' => $entity->getId(),
                'name' => $entity->getName(),
                'type' => $entity->getType(),
                'quantity' => $entity->getQuantity(),
            ]);
            $this->connection->commit();
        } catch (Throwable $throwable) {
            $this->connection->rollBack();
            throw $throwable;
        }
    }

    /** @throws Exception */
    public function findFruits(): ProduceItemCollection
    {
        $result = $this->findByType(ProduceItemDTO::TYPE_FRUIT);

        return $this->produceItemCollectionFactory->createFromDB($result);
    }

    /**
     * @return ProduceItemCollection<ProduceItemInterface>
     * @throws Exception
     */
    public function findVegetables(): ProduceItemCollection
    {
        $result = $this->findByType(ProduceItemDTO::TYPE_VEGETABLE);

        return $this->produceItemCollectionFactory->createFromDB($result);

    }

    /**
     * @return array<int, array<string, mixed>>
     * @throws Exception
     */
    public function findByType(string $type): array
    {
        $queryBuilder = $this->connection->createQueryBuilder()
            ->from('produce', 'p')
            ->select('p.id', 'p.name', 'p.type', 'p.quantity')
            ->where('p.type=:type')
            ->setParameter('type', $type);

        return $queryBuilder->fetchAllAssociative();
    }
}
