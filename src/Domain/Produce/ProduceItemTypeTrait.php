<?php

declare(strict_types=1);

namespace App\Domain\Produce;

use ReflectionClass;

trait ProduceItemTypeTrait
{
    public function getType(): string
    {
        return mb_strtolower(new ReflectionClass($this)->getShortName());
    }
}
