<?php

namespace App\Service\Comparator;

use App\Service\Comparator\Contracts\FactoryComparatorInterface;
use App\Service\Exception\BindingResolutionException;

class FactoryComparator implements FactoryComparatorInterface
{
    /**
     * Registered comparators in factory.
     * @var array
     */
    protected $registered = [];

    /**
     * Register new Comparator in factory.
     * 
     * @param  string $key
     * @param  string $comparator
     * @return $this
     */
    public function registerComparator($key, $comparator)
    {
        $this->registered[$key] = $comparator;

        return $this;
    }

    /**
     * Resolves dependency based the key.
     * 
     * @param  string $key
     * @throws \App\Service\Exception\BindingResolutionException
     * @return mixed
     */
    public function make($key)
    {
        if (! isset($this->registered[$key])) {
            throw new BindingResolutionException("Comparator {$key} is not registered");
        }

        return new $this->registered[$key];
    }
}
