<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Produce\ProduceItemCollection;
use Throwable;

interface ProduceRepositoryInterface
{
    /** @throws Throwable */
    public function saveCollection(ProduceItemCollection $itemCollection): void;
}
