<?php

namespace App\Service\Exception\Contracts;

interface ParserExceptionInterface
{
    /**
     * Parses the exception.
     * 
     * @param  ParseableExceptionInterface $exception
     * @return mixed
     */
    public function parse(ParseableExceptionInterface $exception);
}
