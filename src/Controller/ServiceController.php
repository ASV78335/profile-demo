<?php

namespace App\Controller;

use App\Exception\BusinessLogicException;
use App\Model\RequestAddress;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ServiceController extends AbstractController
{
    public function __construct(private readonly HttpClientInterface $client)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/get-address', methods: ['POST'])]
    public function search(RequestAddress $request): Response
    {
        if (!$request->getOption()) return $this->json([]);

        $apiKey = $_ENV['GEO_API_KEY'];
        if (!$apiKey) throw new BusinessLogicException('API KEY not found');

        $response = $this->client->request(
            'GET',
            'https://suggest-maps.yandex.ru/v1/suggest?apikey=' . $apiKey . '&text=' . $request->getOption()
        );
        try {
            $results =  json_decode($response->getContent())->results;

            $options = [];
            foreach ($results as $option) {
                if (!$option ||
                    !property_exists($option, 'title') ||
                    !property_exists($option, 'subtitle')) continue;

                $options[] = [$option->title->text, $option->subtitle->text];
            }

        } catch (
            ClientExceptionInterface|
            RedirectionExceptionInterface|
            ServerExceptionInterface|
            TransportExceptionInterface $e
        ) {
            throw new BusinessLogicException('Что-то пошло не так: ' . $e->getMessage());
        }

            return $this->json($options);
    }
}
