<?php

declare(strict_types=1);

namespace App\Service;

readonly class ProduceItemDTOFactory
{
    /** @param array<string, int|string> $data */
    public function createFromArray(array $data): ProduceItemDTO
    {
        return new ProduceItemDTO(
            (int)$data['id'],
            (string)$data['name'],
            (string)$data['type'],
            (int)$data['quantity'],
            (string)$data['unit']
        );
    }
}
