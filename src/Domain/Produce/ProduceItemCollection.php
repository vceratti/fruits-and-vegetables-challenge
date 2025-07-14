<?php

declare(strict_types=1);

namespace App\Domain\Produce;

use Ramsey\Collection\AbstractCollection;

/** @extends AbstractCollection<ProduceItemInterface> */
class ProduceItemCollection extends AbstractCollection
{
    public function getType(): string
    {
        return ProduceItemInterface::class;
    }
}
