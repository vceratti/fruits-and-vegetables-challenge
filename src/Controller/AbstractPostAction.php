<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

/** @template-extends  AbstractApiController<null> */
abstract class AbstractPostAction extends AbstractApiController
{
    abstract public function handle(Request $request): void;

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $this->handle($request);
            $response = $this->successfulResponse();
        } catch (Throwable $e) {
            $response = $this->handleError(['message' => $e->getMessage()]);
        }

        return $response;
    }
}
