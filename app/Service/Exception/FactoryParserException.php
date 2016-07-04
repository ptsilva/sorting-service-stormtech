<?php

namespace App\Service\Exception;

use App\Service\Exception\Contracts\FactoryParserExceptionInterface;

class FactoryParserException implements FactoryParserExceptionInterface
{
    /**
     * Registered parsers in factory.
     * 
     * @var array
     */
    protected $registered = [];

    /**
     * Register new Parser in factory.
     * 
     * @param  string $mimeType
     * @param  string $parser
     * @return $this
     */
    public function registerParser($mimeType, $parser)
    {
        $this->registered[$mimeType] = $parser;

        return $this;
    }

    /**
     * Resolves dependency based the mimeType.
     * 
     * @param  string $mimeType
     * @return mixed
     */
    public function make($mimeType)
    {
        return new $this->registered[$mimeType];
    }
}
