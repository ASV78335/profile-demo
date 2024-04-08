<?php

namespace App\Listener;

use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ExceptionListener
{
    private array $defaultExceptions = [
        'App\Exception\BusinessLogicException',
        'App\Exception\RequestBodyConvertException'
    ];

    public function __invoke(ExceptionEvent $event):void
    {
        $request = $event->getRequest();
        $throwable = $event->getThrowable();

        $exceptionClass = get_class($throwable);
        if (in_array($exceptionClass, $this->defaultExceptions)) {

                $response = new Response(
                    json_encode($throwable->getMessage()),
                    Response::HTTP_BAD_REQUEST,
                    ['content-type' => 'application/json']
                );

            $response->prepare($request);
            $event->setResponse($response);
        }

        if ($throwable instanceof ValidationException) {

            $message = $throwable->getMessage() . ':  ';
            $message .= $throwable->getViolations()->get(0)->getMessage();
            $response = new Response(
                json_encode($message),
                Response::HTTP_BAD_REQUEST,
                ['content-type' => 'application/json']
            );

            $response->prepare($request);
            $event->setResponse($response);
        }

        if ($throwable instanceof AccessDeniedException) {

            $message = 'You have to login in order to access this page';
            $response = new Response(
                json_encode($message),
                Response::HTTP_FORBIDDEN,
                ['content-type' => 'application/json']
            );

            $event->setResponse($response);
        }
    }
}
