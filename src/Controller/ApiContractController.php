<?php

namespace App\Controller;


use App\Entity\Contract;
use App\Model\ContractCreateUpdate;
use App\Model\ContractList;
use App\Repository\ContractRepository;
use App\Repository\ProductRepository;
use App\Repository\SubscriberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class ApiContractController extends AbstractController
{
    public function __construct(
        private readonly ContractRepository $repository,
        private readonly ProductRepository $productRepository,
        private readonly SubscriberRepository $subscriberRepository
    )
    {
    }

    #[Route('/api/v1/contracts', methods: ['GET'])]
    public function getAll(): Response
    {
        $contracts = $this->repository->findAll();
        $response = new ContractList(array_map(
            fn (Contract $contract) => $contract->toResponseItem(), $contracts
        ));
        return $this->json($response);
    }


    #[Route('/api/v1/contract/{uuid}', methods: ['GET'])]
    public function getContract(Uuid $uuid): Response
    {
        $contract = $this->repository->findOneBy(['uuid' => $uuid]);
        return $this->json($contract->toResponseItem());
    }


    #[Route('/api/v1/contract', methods: ['POST'])]
    public function create(ContractCreateUpdate $request): Response
    {
        $contract = new Contract();
        $product = $this->productRepository->findOneBy(['uuid' => $request->getProductUuid()]);
        $subscriber = $this->subscriberRepository->findOneBy(['uuid' => $request->getSubscriberUuid()]);
        $result = $contract::fromCreateRequest($request, $product, $subscriber);
        $this->repository->save($result);
        return $this->json($result);
    }


    #[Route('/api/v1/contract/{uuid}', methods: ['POST'])]
    public function update(Uuid $uuid, ContractCreateUpdate $request): Response
    {
        $contract = $this->repository->findOneBy(['uuid' => $uuid]);
        $product = $this->productRepository->findOneBy(['uuid' => $request->getProductUuid()]);
        $subscriber = $this->subscriberRepository->findOneBy(['uuid' => $request->getSubscriberUuid()]);
        $result = $contract::fromUpdateRequest($contract, $request, $product, $subscriber);
        $this->repository->save($result);
        return $this->json($result);
    }
}
