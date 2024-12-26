<?php
declare(strict_types=1);

namespace App\Core\EventListener;

use App\Exception\PaymentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    const MIME_JSON = 'application/json';

    public function onKernelException(ExceptionEvent $event): void
    {
        $acceptHeader = $event->getRequest()->headers->get('Accept');

        if ($acceptHeader === self::MIME_JSON) {
            $exception = $event->getThrowable();
            $response = new JsonResponse($this->exceptionToJson($exception));

            if (
                $exception instanceof HttpExceptionInterface
                || $exception instanceof PaymentException
            ) {
                $response->setStatusCode($exception->getStatusCode());
            } else {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $event->setResponse($response);
        }
    }

    public function exceptionToJson(\Throwable $exception): array
    {
        return [
            'status' => 'error',
            'message' => $exception->getMessage(),
            'data' => [],
        ];
    }
}