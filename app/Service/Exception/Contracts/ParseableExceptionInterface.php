<?php

namespace App\Service\Exception\Contracts;

interface ParseableExceptionInterface
{
    /**
     * Set parser to exception.
     * @param ParserExceptionInterface $parser
     */
    public function setParser(ParserExceptionInterface $parser);

    /**
     * Return parser content from the exception.
     * 
     * @return mixed
     */
    public function getParsedException();
}
