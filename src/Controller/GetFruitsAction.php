<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Produce\ProduceItemCollection;
use App\Domain\Produce\ProduceItemInterface;
use App\Repository\ProduceRepositoryInterface;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

/** @extends AbstractGetCollectionAction<ProduceItemInterface> */
#[Route('/api/fruits', methods: ['GET'])]
class GetFruitsAction extends AbstractGetCollectionAction
{
    public function __construct(
        private readonly ProduceRepositoryInterface $fruitRepository
    ) {
    }

    /** @throws Exception */
    public function handle(Request $request): ProduceItemCollection
    {
        return $this->fruitRepository->findFruits();
    }
}
