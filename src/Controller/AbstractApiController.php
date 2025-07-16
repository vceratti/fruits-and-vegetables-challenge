<?php

declare(strict_types=1);

namespace App\Controller;

use Ramsey\Collection\CollectionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/** @template T */
abstract class AbstractApiController extends AbstractController
{
    abstract public function __invoke(Request $request): JsonResponse;

    /** @param CollectionInterface<T>|null $result */
    protected function successfulResponse(?CollectionInterface $result = null): JsonResponse
    {
        return $this->json($result, Response::HTTP_OK);
    }

    /** @param array<string, mixed> $result */
    protected function handleError(array $result): JsonResponse
    {
        return $this->json($result, Response::HTTP_BAD_REQUEST);
    }
}
