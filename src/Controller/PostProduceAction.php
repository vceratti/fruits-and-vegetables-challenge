<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Produce\ProduceItemFactory;
use App\Repository\ProduceRepositoryInterface;
use App\Service\ProduceItemDTOFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/produce', methods: ['POST'])]
class PostProduceAction extends AbstractPostAction
{
    public function __construct(
        private readonly ProduceRepositoryInterface $produceRepository,
        private readonly ProduceItemDTOFactory      $produceItemDTOFactory,
        private readonly ProduceItemFactory         $produceItemFactory,
    ) {
    }

    public function handle(Request $request): void
    {
        $dto = $this->produceItemDTOFactory->createFromArray($request->request->all());
        $entity = $this->produceItemFactory->createFromDTO($dto);

        $this->produceRepository->saveProduce($entity);
    }
}
