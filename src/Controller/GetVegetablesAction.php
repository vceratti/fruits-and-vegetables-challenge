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
#[Route('/api/vegetables', methods: ['GET'])]
class GetVegetablesAction extends AbstractGetCollectionAction
{
    public function __construct(
        private readonly ProduceRepositoryInterface $produceRepository
    ) {
    }

    /** @throws Exception */
    public function handle(Request $request): ProduceItemCollection
    {
        return $this->produceRepository->findVegetables();
    }
}
