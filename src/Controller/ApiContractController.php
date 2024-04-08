<?php

namespace App\Controller;


use App\Entity\Contract;
use App\Exception\BusinessLogicException;
use App\Model\ContractCreateUpdate;
use App\Model\ContractList;
use App\Model\RequestAddress;
use App\Model\RequestDate;
use App\Model\RequestPeriod;
use App\Model\RequestProduct;
use App\Repository\ContractRepository;
use App\Repository\ProductRepository;
use App\Repository\SubscriberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;
use Throwable;

class ApiContractController extends AbstractController
{
    public function __construct(
        private readonly ContractRepository $repository,
        private readonly ProductRepository $productRepository,
        private readonly SubscriberRepository $subscriberRepository
    )
    {
    }

    #[Route('/api/v1/contracts-by-date', methods: ['POST'])]
    public function getByDate(RequestDate $request): Response
    {
        $contracts = $this->repository->findBy(['signedAt' => $request->getDate()]);

        $response = new ContractList(array_map(
            fn (Contract $contract) => $contract->toResponseItem(), $contracts
        ));
        return $this->json($response);
    }

    #[Route('/api/v1/contracts-by-address', methods: ['POST'])]
    public function getByAddress(RequestAddress $request): Response
    {
        $contracts = $this->repository->findByAddress($request->getOption());

        $response = new ContractList(array_map(
            fn (Contract $contract) => $contract->toResponseItem(), $contracts
        ));
        return $this->json($response);
    }

    #[Route('/api/v1/contracts-by-product', methods: ['POST'])]
    public function getByProduct(RequestProduct $request): Response
    {
        $product = $this->productRepository->findOneBy(['uuid' => $request->getUuid()]);
        $contracts = $this->repository->findByProduct($product);

        $response = new ContractList(array_map(
            fn (Contract $contract) => $contract->toResponseItem(), $contracts
        ));
        return $this->json($response);
    }


    #[Route('/api/v1/contracts-by-period', methods: ['POST'])]
    public function getByPeriod(RequestPeriod $request): Response
    {
        if ($request->getStartDate() > $request->getFinalDate()) throw new BusinessLogicException('Invalid range');

        $contracts = $this->repository->findByPeriod($request->getStartDate(), $request->getFinalDate());

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
        if (!$product) throw new BusinessLogicException('Product not found');
        $subscriber = $this->subscriberRepository->findOneBy(['uuid' => $request->getSubscriberUuid()]);
        if (!$subscriber) throw new BusinessLogicException('Subscriber not found');
        try {
            $result = $contract::fromCreateRequest($request, $product, $subscriber);
            $this->repository->save($result);
            return $this->json($result);
        } catch (Throwable $throwable) {
            throw new BusinessLogicException('Ошибка сохранения:' . $throwable->getMessage());
        }
    }


    #[Route('/api/v1/contract/{uuid}', methods: ['POST'])]
    public function update(Uuid $uuid, ContractCreateUpdate $request): Response
    {
        $contract = $this->repository->findOneBy(['uuid' => $uuid]);
        if (!$contract) throw new BusinessLogicException('Contract not found');
        $product = $this->productRepository->findOneBy(['uuid' => $request->getProductUuid()]);
        if (!$product) throw new BusinessLogicException('Product not found');
        $subscriber = $this->subscriberRepository->findOneBy(['uuid' => $request->getSubscriberUuid()]);
        if (!$subscriber) throw new BusinessLogicException('Subscriber not found');
        try {
            $result = $contract::fromUpdateRequest($contract, $request, $product, $subscriber);
            $this->repository->save($result);
            return $this->json($result);
        } catch (Throwable $throwable) {
            throw new BusinessLogicException('Ошибка сохранения:' . $throwable->getMessage());
        }
    }
}
