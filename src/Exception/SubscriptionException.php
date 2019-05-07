<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

/**
 * Class SubscriptionException
 * @package App\Exception
 */
class SubscriptionException extends Exception
{
    /**
     * SubscriptionException constructor.
     * @param string $message
     * @param int $code
     * @param Exception|null $exception
     */
    public function __construct(string $message, int $code = 0, Exception $exception = null)
    {
        $message = sprintf('Subscription Exception %d : %s', $code, $message);

        parent::__construct($message, $code, $exception);
    }
}