<?php

declare(strict_types=1);

namespace Controller;

use App\Controller\PostProduceAction;
use Doctrine\DBAL\Exception;
use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use Tests\IntegrationTestCase;

#[CoversClass(PostProduceAction::class)]
#[Group('integration')]
class PostProduceActionTest extends IntegrationTestCase
{
    /**
     * @param array<string, int|string> $postItem
     * @throws Exception
     */
    #[DataProvider('produceDataProvider')]
    public function testPostProduceAction(array $postItem): void
    {
        $this->client->request('POST', '/api/produce', $postItem);

        $this->assertResponseIsSuccessful();

        $result = $this->dbFetch('produce');

        $this->assertCount(1, $result);
        $this->assertSame($postItem['id'], $result[0]['id']);
        $this->assertSame($postItem['name'], $result[0]['name']);
        $this->assertSame($postItem['type'], $result[0]['type']);

        $expectedQuantity = (int)$postItem['quantity'];
        if ($postItem['unit'] === 'kg') {
            $expectedQuantity *= 1000;
        }
        $this->assertSame($expectedQuantity, $result[0]['quantity']);
    }

    public static function produceDataProvider(): Generator
    {
        yield 'fruit' => [
            ['id' => 1, 'name' => 'Banana', 'type' => 'fruit', 'quantity' => 100, 'unit' => 'g',],
        ];

        yield 'vegetable' => [
            ['id' => 1, 'name' => 'Potato', 'type' => 'vegetable', 'quantity' => 5, 'unit' => 'kg',],
        ];
    }
}
