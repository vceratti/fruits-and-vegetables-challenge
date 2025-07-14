<?php

declare(strict_types=1);

namespace App\Service;

use function json_decode;

use JsonException;
use RuntimeException;

readonly class JsonFileReader
{
    /**
     * @return array<int, mixed>
     * @throws JsonException|RuntimeException
     */
    public function read(string $filepath): array
    {
        if (!file_exists($filepath)) {
            throw new RuntimeException("File not found: {$filepath}");
        }

        $content = file_get_contents($filepath);
        if ($content === false) {
            throw new RuntimeException("Could not read file: {$filepath}");
        }

        try {
            return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new JsonException(
                "Invalid JSON in file {$filepath}: {$e->getMessage()}",
                0,
                $e
            );
        }
    }

}
