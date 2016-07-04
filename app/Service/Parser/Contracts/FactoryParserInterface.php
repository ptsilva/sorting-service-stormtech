<?php

namespace App\Service\Parser\Contracts;

interface FactoryParserInterface
{
    /**
     * Register new Parser in factory.
     * 
     * @param  string $type
     * @param  string $parser
     * @return $this
     */
    public function registerParser($type, $parser);

    /**
     * Resolves dependency based type.
     * 
     * @param  string $type
     * @return mixed
     */
    public function make($type);
}
