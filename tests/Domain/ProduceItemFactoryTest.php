<?php

declare(strict_types=1);

namespace Tests\Domain;

use App\Domain\Produce\Fruit\Fruit;
use App\Domain\Produce\Fruit\FruitCreationStrategy;
use App\Domain\Produce\ProduceItemFactory;
use App\Domain\Produce\Vegetable\Vegetable;
use App\Domain\Produce\Vegetable\VegetableCreationStrategy;
use App\Service\ProduceItemDTO;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use Tests\IntegrationTestCase;

#[CoversClass(ProduceItemFactory::class)]
#[CoversClass(VegetableCreationStrategy::class)]
#[CoversClass(FruitCreationStrategy::class)]
#[Group('integration')]
final class ProduceItemFactoryTest extends IntegrationTestCase
{
    /**
     * @param class-string<object> $expectedClass
     * *@throws Exception
     */
    #[DataProvider('validProduceItems')]
    public function testCreatesProduceItemFromDTO(ProduceItemDTO $dto, string $expectedClass): void
    {
        $factory = $this->getFromContainer(ProduceItemFactory::class);
        $item = $factory->createFromDTO($dto);

        self::assertInstanceOf($expectedClass, $item);
        self::assertSame($dto->getId(), $item->getId());
        self::assertSame($dto->getName(), $item->getName());
        self::assertSame($dto->getQuantityInGrams(), $item->getQuantity());
    }

    /** @return iterable<string, array<int, ProduceItemDTO|class-string<object>>> */
    public static function validProduceItems(): iterable
    {
        yield 'fruit ' => [
            new ProduceItemDTO(1, 'Apple', ProduceItemDTO::TYPE_FRUIT, 100, ProduceItemDTO::UNIT_GRAM),
            Fruit::class
        ];
        yield 'vegetable' => [
            new ProduceItemDTO(2, 'Broccoli', ProduceItemDTO::TYPE_VEGETABLE, 200, ProduceItemDTO::UNIT_GRAM),
            Vegetable::class
        ];
    }

    public function testThrowsForUnknownType(): void
    {
        $dto = new ProduceItemDTO(3, 'Mystery', 'fruit', 50, ProduceItemDTO::UNIT_GRAM);

        $this->expectException(InvalidArgumentException::class);

        $factory = new ProduceItemFactory([
            new VegetableCreationStrategy(),
        ]);

        $factory->createFromDTO($dto);
    }
}
