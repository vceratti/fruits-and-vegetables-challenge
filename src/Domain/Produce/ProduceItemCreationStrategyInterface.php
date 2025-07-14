<?php

declare(strict_types=1);

namespace App\Domain\Produce;

use App\Service\ProduceItemDTO;

interface ProduceItemCreationStrategyInterface
{
    public function supports(ProduceItemDTO $dto): bool;

    public function create(ProduceItemDTO $dto): ProduceItemInterface;
}
