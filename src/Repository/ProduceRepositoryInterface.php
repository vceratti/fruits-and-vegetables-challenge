<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Produce\ProduceItemCollection;
use App\Domain\Produce\ProduceItemInterface;
use Doctrine\DBAL\Exception;
use Throwable;

interface ProduceRepositoryInterface
{
    /**
     * @param ProduceItemCollection<ProduceItemInterface> $itemCollection
     * @throws Throwable
     */
    public function saveCollection(ProduceItemCollection $itemCollection): void;

    public function saveProduce(ProduceItemInterface $entity): void;

    /** @throws Exception */
    public function findFruits(): ProduceItemCollection;

    /** @throws Exception */
    public function findVegetables(): ProduceItemCollection;
}
