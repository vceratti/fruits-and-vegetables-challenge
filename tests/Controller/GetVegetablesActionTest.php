<?php

declare(strict_types=1);

namespace Controller;

use App\Controller\GetVegetablesAction;
use Doctrine\DBAL\Exception;
use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use Tests\IntegrationTestCase;

#[CoversClass(GetVegetablesAction::class)]
#[Group('integration')]
class GetVegetablesActionTest extends IntegrationTestCase
{
    /**
     * @param array<int, array<string, int|string>> $expectedItems
     * @throws Exception
     */
    #[DataProvider('produceDataProvider')]
    public function testGetVegetablesAction(array $expectedItems, int $expectedFruits): void
    {
        $this->batchInsert('produce', $expectedItems);

        $this->client->request('GET', '/api/vegetables');

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
        yield 'vegetables' => [
            'expectedItems' => [
                ['id' => 1, 'name' => 'Tomato', 'type' => 'vegetable', 'quantity' => 100],
                ['id' => 2, 'name' => 'Potato', 'type' => 'vegetable', 'quantity' => 50],
                ['id' => 3, 'name' => 'Banana', 'type' => 'fruit', 'quantity' => 30],
            ],
            'expectedFruits' => 2,
        ];
    }
}
