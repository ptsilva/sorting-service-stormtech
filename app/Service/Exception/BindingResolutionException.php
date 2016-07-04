<?php

namespace App\Service\Exception;

use App\Service\Exception\Contracts\ParseableExceptionInterface;
use App\Service\Exception\Contracts\ParserExceptionInterface;
use Exception;

class BindingResolutionException extends Exception implements ParseableExceptionInterface
{
    /**
     * Parser used to analyse the exception.
     * 
     * @var \App\Service\Exception\Contracts\ParseableExceptionInterface
     */
    protected $parser;

    /**
     * Set parser to exception.
     * 
     * @param ParserExceptionInterface $parser
     */
    public function setParser(ParserExceptionInterface $parser)
    {
        $this->parser = $parser;

        return $this;
    }

    /**
     * Return parser content from the exception.
     * 
     * @return mixed
     */
    public function getParsedException()
    {
        return $this->parser->parse($this);
    }
}
