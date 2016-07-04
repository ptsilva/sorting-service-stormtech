<?php

namespace App\Service\Exception;

use App\Service\Exception\Contracts\ParserExceptionInterface;
use App\Service\Exception\Contracts\ParseableExceptionInterface;

class JsonParserException implements ParserExceptionInterface
{
    /**
     * Parses the exception.
     * 
     * @param  ParseableExceptionInterface $exception
     * @return mixed
     */
    public function parse(ParseableExceptionInterface $exception)
    {
        return json_encode([
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
        ]);
    }
}
