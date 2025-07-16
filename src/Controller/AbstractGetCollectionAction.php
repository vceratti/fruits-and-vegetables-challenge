<?php

declare(strict_types=1);

namespace App\Controller;

use Ramsey\Collection\CollectionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

/**
 * @template T
 * @extends AbstractApiController<T>
 */
abstract class AbstractGetCollectionAction extends AbstractApiController
{
    /** @return CollectionInterface<T> */
    abstract public function handle(Request $request): CollectionInterface;

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            $response = $this->successfulResponse($result);
        } catch (Throwable $e) {
            $response = $this->handleError(['message' => $e->getMessage()]);
        }

        return $response;
    }
}
