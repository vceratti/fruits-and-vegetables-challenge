<?php

declare(strict_types=1);

namespace App\Tests\App\Service;

use App\Service\StorageService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[CoversClass(StorageService::class)]
#[Group('unit')]
class StorageServiceTest extends TestCase
{
    public function testReceivingRequest(): void
    {
        $request = (string)file_get_contents('request.json');

        $storageService = new StorageService($request);

        $this->assertNotEmpty($storageService->getRequest());
    }
}
