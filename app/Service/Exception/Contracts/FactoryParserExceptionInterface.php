<?php

namespace App\Service\Exception\Contracts;

interface FactoryParserExceptionInterface
{
    /**
     * Register new parser exception in factory.
     * 
     * @param  string $mimeType
     * @param  string $parser
     * @return $this
     */
    public function registerParser($mimeType, $parser);

    /**
     * Resolves dependency based the mime type.
     * 
     * @param  string $key
     * @return mixed
     */
    public function make($mimeType);
}
