<?php

namespace App\Controller;


use App\Entity\Subscriber;
use App\Model\SubscriberCreateUpdate;
use App\Model\SubscriberList;
use App\Repository\SubscriberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class ApiSubscriberController extends AbstractController
{
    public function __construct(
        private readonly SubscriberRepository $repository
    )
    {
    }

    #[Route('/api/v1/subscribers', methods: ['GET'])]
    public function getAll(): Response
    {
        $subscribers = $this->repository->findAll();
        $response = new SubscriberList(array_map(
            fn (Subscriber $subscriber) => $subscriber->toResponseItem(), $subscribers
        ));
        return $this->json($response);
    }


    #[Route('/api/v1/subscriber/{uuid}', methods: ['GET'])]
    public function getSubscriber(Uuid $uuid): Response
    {
        $subscriber = $this->repository->findOneBy(['uuid' => $uuid]);
        return $this->json($subscriber->toResponseItem());
    }


    #[Route('/api/v1/subscriber', methods: ['POST'])]
    public function create(SubscriberCreateUpdate $request): Response
    {
        $subscriber = new Subscriber();
        $result = $subscriber::fromCreateRequest($request);
        $this->repository->save($result);
        return $this->json($result);
    }


    #[Route('/api/v1/subscriber/{uuid}', methods: ['POST'])]
    public function update(Uuid $uuid, SubscriberCreateUpdate $request): Response
    {
        $subscriber = $this->repository->findOneBy(['uuid' => $uuid]);
        $result = $subscriber::fromUpdateRequest($subscriber, $request);
        $this->repository->save($result);
        return $this->json($result);
    }
}
