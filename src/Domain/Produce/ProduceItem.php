<?php

declare(strict_types=1);

namespace App\Domain\Produce;

abstract readonly class ProduceItem implements ProduceItemInterface
{
    use ProduceItemTypeTrait;

    public function __construct(
        private int    $id,
        private string $name,
        private int    $quantity,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
