<?php

declare(strict_types=1);

namespace Tests;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Throwable;

abstract class IntegrationTestCase extends WebTestCase
{
    //    private KernelBrowser $client;

    /** @throws Exception */
    protected function setUp(): void
    {
        parent::setUp();
        //        $this->client = $this->createClient();
        $this->getConnection()->beginTransaction();
    }

    public function getConnection(): Connection
    {
        return $this->getFromContainer(Connection::class);
    }

    /** @throws Exception */
    protected function tearDown(): void
    {
        $this->getConnection()->rollBack();
        parent::tearDown();
    }

    /**
     * @template T
     * @param class-string<T> $className
     * @return T
     */
    public static function getFromContainer(string $className)
    {
        try {
            $object = self::getContainer()->get($className);
            if (!($object instanceof $className)) {
                throw new RuntimeException("Expected instance of $className, got " . get_class($object));
            }
        } catch (Throwable $e) {
            self::fail('Failed to get service from container: ' . $e->getMessage());
        }

        return $object;
    }

}
