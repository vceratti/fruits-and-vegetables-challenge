<?php

declare(strict_types=1);

namespace Tests\Service;

use App\Service\ProduceItemDTO;
use App\Service\ProduceItemDTOFactory;
use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[CoversClass(ProduceItemDTOFactory::class)]
#[Group('unit')]
class ProduceItemDTOFactoryTest extends TestCase
{
    /** @param array<string, int|string> $data */
    #[DataProvider('validProduceProvider')]
    public function testCreateFromArray(array $data, int $expectedGrams): void
    {
        $factory = new ProduceItemDTOFactory();
        $dto = $factory->createFromArray($data);

        $this->assertSame($data['id'], $dto->getId());
        $this->assertSame($data['name'], $dto->getName());
        $this->assertSame($data['type'], $dto->getType());
        $this->assertSame($data['quantity'], $dto->getQuantity());
        $this->assertSame($data['unit'], $dto->getUnit());
        $this->assertSame($expectedGrams, $dto->getQuantityInGrams());
    }

    public static function validProduceProvider(): Generator
    {
        yield 'fruit-grams' => [
            [
                'id' => 1,
                'name' => 'Apple',
                'type' => ProduceItemDTO::TYPE_FRUIT,
                'quantity' => 500,
                'unit' => ProduceItemDTO::UNIT_GRAM,
            ],
            500
        ];

        yield 'veggie-kilograms' => [
            [
                'id' => 2,
                'name' => 'Carrot',
                'type' => ProduceItemDTO::TYPE_VEGETABLE,
                'quantity' => 3,
                'unit' => ProduceItemDTO::UNIT_KILOGRAM,
            ],
            3000
        ];

        yield 'fruit-kilograms' => [
            [
                'id' => 3,
                'name' => 'Banana',
                'type' => ProduceItemDTO::TYPE_FRUIT,
                'quantity' => 2,
                'unit' => ProduceItemDTO::UNIT_KILOGRAM,
            ],
            2000
        ];
    }
}
