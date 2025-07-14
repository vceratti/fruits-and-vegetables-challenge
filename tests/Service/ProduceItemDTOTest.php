<?php

declare(strict_types=1);

namespace Tests\Service;

use App\Service\ProduceItemDTO;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[CoversClass(ProduceItemDTO::class)]
#[Group('unit')]
class ProduceItemDTOTest extends TestCase
{
    #[DataProvider('validDataProvider')]
    public function testValidConstruction(
        int    $id,
        string $name,
        string $type,
        int    $quantity,
        string $unit,
        int    $expectedGrams
    ): void {
        $dto = new ProduceItemDTO($id, $name, $type, $quantity, $unit);

        $this->assertSame($id, $dto->getId());
        $this->assertSame($name, $dto->getName());
        $this->assertSame($type, $dto->getType());
        $this->assertSame($quantity, $dto->getQuantity());
        $this->assertSame($unit, $dto->getUnit());
        $this->assertSame($expectedGrams, $dto->getQuantityInGrams());
    }

    public static function validDataProvider(): Generator
    {
        yield 'fruit-grams' => [1, 'Apple', ProduceItemDTO::TYPE_FRUIT, 350, ProduceItemDTO::UNIT_GRAM, 350];
        yield 'veg-kilos' => [2, 'Carrot', ProduceItemDTO::TYPE_VEGETABLE, 2, ProduceItemDTO::UNIT_KILOGRAM, 2000];
        yield 'fruit-kilos' => [3, 'Banana', ProduceItemDTO::TYPE_FRUIT, 3, ProduceItemDTO::UNIT_KILOGRAM, 3000];
    }

    #[DataProvider('invalidDataProvider')]
    public function testInvalidConstruction(
        int    $id,
        string $name,
        string $type,
        int    $quantity,
        string $unit,
        string $expectedMessage
    ): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedMessage);
        new ProduceItemDTO($id, $name, $type, $quantity, $unit);
    }

    public static function invalidDataProvider(): Generator
    {
        yield 'zero id' => [0, 'Apple', ProduceItemDTO::TYPE_FRUIT, 100, ProduceItemDTO::UNIT_GRAM, 'Id must be greater than 0.'];
        yield 'negative id' => [-1, 'Apple', ProduceItemDTO::TYPE_FRUIT, 100, ProduceItemDTO::UNIT_GRAM, 'Id must be greater than 0.'];
        yield 'zero quantity' => [1, 'Apple', ProduceItemDTO::TYPE_FRUIT, 0, ProduceItemDTO::UNIT_GRAM, 'Quantity must be greater than 0.'];
        yield 'negative quantity' => [1, 'Apple', ProduceItemDTO::TYPE_FRUIT, -1, ProduceItemDTO::UNIT_GRAM, 'Quantity must be greater than 0.'];
        yield 'empty name' => [2, '', ProduceItemDTO::TYPE_FRUIT, 50, ProduceItemDTO::UNIT_GRAM, 'Name cannot be empty.'];
        yield 'invalid type' => [3, 'Orange', 'berry', 50, ProduceItemDTO::UNIT_GRAM, 'Invalid produce type "berry". Allowed types are: fruit, vegetable'];
        yield 'invalid unit' => [4, 'Apple', ProduceItemDTO::TYPE_FRUIT, 50, 'litre', 'Invalid unit "litre". Allowed units are: g, kg'];
    }
}
