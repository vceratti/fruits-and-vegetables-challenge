<?php

declare(strict_types=1);

namespace App\Domain\Produce;

interface ProduceItemInterface
{
    public function getId(): int;

    public function getName(): string;

    public function getQuantity(): int;

    public function getType(): string;
}
