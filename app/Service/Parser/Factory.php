<?php

namespace App\Service\Parser;

use App\Service\Parser\Contracts\FactoryParserInterface;
use App\Service\Exception\BindingResolutionException;

class Factory implements FactoryParserInterface
{
    /**
     * Registered comparators in factory.
     * 
     * @var array
     */
    protected $registered = [];

    /**
     * Register new Parser in factory.
     * 
     * @param  string $type
     * @param  string $parser
     * @return $this
     */
    public function registerParser($type, $parser)
    {
        $this->registered[$type] = $parser;

        return $this;
    }

    /**
     * Resolves dependency based type.
     * 
     * @param  string $type
     * @throws \App\Service\Exception\BindingResolutionException
     * @return mixed
     */
    public function make($type)
    {
        if (! isset($this->registered[$type])) {
            throw new BindingResolutionException("Comparator {$type} is not registered");
        }

        return new $this->registered[$type];
    }
}
