<?php

declare(strict_types=1);

namespace App\Service;

use InvalidArgumentException;

readonly class ProduceItemDTO
{
    public const string TYPE_FRUIT = 'fruit';
    public const string TYPE_VEGETABLE = 'vegetable';

    public const string UNIT_GRAM = 'g';
    public const string UNIT_KILOGRAM = 'kg';

    private const int GRAMS_PER_KILOGRAM = 1000;

    public function __construct(
        private int    $id,
        private string $name,
        private string $type,
        private int    $quantity,
        private string $unit
    ) {
        if ($id <= 0) {
            throw new InvalidArgumentException('Id must be greater than 0.');
        }
        if ($quantity <= 0) {
            throw new InvalidArgumentException('Quantity must be greater than 0.');
        }
        if ($name === '') {
            throw new InvalidArgumentException('Name cannot be empty.');
        }

        $this->validateType($type);
        $this->validateUnit($unit);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function getQuantityInGrams(): int
    {
        if ($this->unit === self::UNIT_KILOGRAM) {
            return $this->quantity * self::GRAMS_PER_KILOGRAM;
        }

        return $this->quantity;
    }

    private function validateType(string $type): void
    {
        $allowedTypes = [self::TYPE_FRUIT, self::TYPE_VEGETABLE];

        if (!in_array($type, $allowedTypes, true)) {
            $message = "Invalid produce type \"$type\". Allowed types are: " . implode(', ', $allowedTypes);
            throw new InvalidArgumentException($message);
        }
    }

    private function validateUnit(string $unit): void
    {
        $allowedUnits = [self::UNIT_GRAM, self::UNIT_KILOGRAM];

        if (!in_array($unit, $allowedUnits, true)) {
            $message = "Invalid unit \"$unit\". Allowed units are: " . implode(', ', $allowedUnits);
            throw new InvalidArgumentException($message);
        }
    }
}
