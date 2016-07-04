<?php

namespace App\Service\Comparator\Contracts;

interface FactoryComparatorInterface
{
    /**
     * Register new Comparator in factory.
     * @param  string $key
     * @param  string $comparator
     * @return $this
     */
    public function registerComparator($key, $comparator);

    /**
     * Resolves dependency based the key.
     * @param  string $key
     * @return mixed
     */
    public function make($key);
}
