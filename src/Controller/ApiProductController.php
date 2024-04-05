<?php

namespace App\Controller;


use App\Entity\Product;
use App\Model\ProductCreateUpdate;
use App\Model\ProductList;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class ApiProductController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $repository
    )
    {
    }

    #[Route('/api/v1/products', methods: ['GET'])]
    public function getAll(): Response
    {
        $products = $this->repository->findAll();
        $response = new ProductList(array_map(
            fn (Product $product) => $product->toResponseItem(), $products
        ));
        return $this->json($response);
    }


    #[Route('/api/v1/product/{uuid}', methods: ['GET'])]
    public function getProduct(Uuid $uuid): Response
    {
        $product = $this->repository->findOneBy(['uuid' => $uuid]);
        return $this->json($product->toResponseItem());
    }


    #[Route('/api/v1/product', methods: ['POST'])]
    public function create(ProductCreateUpdate $request): Response
    {
        $product = new Product();
        $result = $product::fromCreateRequest($request);
        $this->repository->save($result);
        return $this->json($result);
    }


    #[Route('/api/v1/product/{uuid}', methods: ['POST'])]
    public function update(Uuid $uuid, ProductCreateUpdate $request): Response
    {
        $product = $this->repository->findOneBy(['uuid' => $uuid]);
        $result = $product::fromUpdateRequest($product, $request);
        $this->repository->save($result);
        return $this->json($result);
    }
}
