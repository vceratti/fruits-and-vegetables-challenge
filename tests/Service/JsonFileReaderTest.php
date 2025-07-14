<?php

declare(strict_types=1);

namespace Tests\Service;

use App\Service\JsonFileReader;
use JsonException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use RuntimeException;

#[CoversClass(JsonFileReader::class)]
#[Group('unit')]
class JsonFileReaderTest extends TestCase
{
    private JsonFileReader $jsonFileReader;

    protected function setUp(): void
    {
        $this->jsonFileReader = new JsonFileReader();
    }

    /** @throws JsonException */
    public function testReadValidJsonFile(): void
    {
        $result = $this->jsonFileReader->read(__DIR__ . '/../../request.json');

        $this->assertCount(20, $result);

        $firstItem = $result[0];
        $this->assertArrayHasKey('id', $firstItem);
        $this->assertArrayHasKey('name', $firstItem);
        $this->assertArrayHasKey('type', $firstItem);
        $this->assertArrayHasKey('quantity', $firstItem);
        $this->assertArrayHasKey('unit', $firstItem);

        $this->assertSame(1, $firstItem['id']);
        $this->assertSame('Carrot', $firstItem['name']);
        $this->assertSame('vegetable', $firstItem['type']);
        $this->assertSame(10922, $firstItem['quantity']);
        $this->assertSame('g', $firstItem['unit']);
    }

    /** @throws JsonException */
    public function testReadNonExistentFile(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('File not found: non_existent_file.json');

        $this->jsonFileReader->read('non_existent_file.json');
    }

    public function testReadInvalidJsonFile(): void
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'invalid_json_');
        file_put_contents($tempFile, '{invalid json}');

        $this->expectException(JsonException::class);

        try {
            $this->jsonFileReader->read($tempFile);
        } finally {
            unlink($tempFile);
        }
    }

    public function testReadEmptyFile(): void
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'empty_json_');
        file_put_contents($tempFile, '');

        $this->expectException(JsonException::class);

        try {
            $this->jsonFileReader->read($tempFile);
        } finally {
            unlink($tempFile);
        }
    }
}
