<?php

declare(strict_types=1);

namespace Tests\Controller;

use App\Controller\GetFruitsAction;
use Doctrine\DBAL\Exception;
use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use Tests\IntegrationTestCase;

#[CoversClass(GetFruitsAction::class)]
#[Group('integration')]
class GetFruitsActionTest extends IntegrationTestCase
{
    /**
     * @throws Exception
     * @param array<int, array<string, int|string>> $expectedItems
     */
    #[DataProvider('produceDataProvider')]
    public function testGetFruitsAction(array $expectedItems, int $expectedFruits): void
    {
        $this->batchInsert('produce', $expectedItems);

        $this->client->request('GET', '/api/fruits');

        $this->assertResponseIsSuccessful();

        $response = $this->client->getResponse();

        $data = json_decode((string)$response->getContent(), true);
        $this->assertCount($expectedFruits, $data);

        $this->assertSame($expectedItems[0]['id'], $data[0]['id']);
        $this->assertSame($expectedItems[0]['name'], $data[0]['name']);
        $this->assertSame($expectedItems[0]['type'], $data[0]['type']);
        $this->assertSame($expectedItems[0]['quantity'], $data[0]['quantity']);

        $this->assertSame($expectedItems[1]['id'], $data[1]['id']);
        $this->assertSame($expectedItems[1]['name'], $data[1]['name']);
        $this->assertSame($expectedItems[1]['type'], $data[1]['type']);
        $this->assertSame($expectedItems[1]['quantity'], $data[1]['quantity']);
    }

    public static function produceDataProvider(): Generator
    {
        yield 'fruit' => [
            'expectedItems' => [
                ['id' => 1, 'name' => 'Apple', 'type' => 'fruit', 'quantity' => 100],
                ['id' => 2, 'name' => 'Banana', 'type' => 'fruit', 'quantity' => 50],
                ['id' => 3, 'name' => 'potato', 'type' => 'vegetable', 'quantity' => 30],
            ],
            'expectedFruits' => 2,
        ];

    }

}
