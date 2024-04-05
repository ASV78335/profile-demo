<?php

namespace App\Listener;

use App\Exception\RequestBodyConvertException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{

    public function __invoke(ExceptionEvent $event):void
    {
        $request = $event->getRequest();
        $throwable = $event->getThrowable();

        if ($throwable instanceof RequestBodyConvertException) {

                $response = new Response(
                    json_encode($throwable->getMessage()),
                    Response::HTTP_BAD_REQUEST,
                    ['content-type' => 'application/json']
                );

            $response->prepare($request);
            $event->setResponse($response);
        }

    }
}
