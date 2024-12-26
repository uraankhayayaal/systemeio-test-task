<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class PaymentException extends \RuntimeException implements HttpExceptionInterface
{
    /**
     * Returns the status code.
     */
    public function getStatusCode(): int
    {
        return 422;
    }

    /**
     * Returns response headers.
     */
    public function getHeaders(): array
    {
        return [];
    }
}
