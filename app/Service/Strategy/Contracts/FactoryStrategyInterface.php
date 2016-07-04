<?php

namespace App\Service\Strategy\Contracts;

interface FactoryStrategyInterface
{
    /**
     * Register a new strategy in factory.
     * 
     * @param  string $type
     * @param  string $strategy
     * @param  string $comparator
     * @return $this
     */
    public function registerStrategy($key, $strategy, $comparator);

    /**
     * Crates a new strategy from array.
     * 
     * @param  array $source
     * @param  \App\Service\Strategy\Contracts\SortStrategyInterface|null $current
     * @return \App\Service\Strategy\Contracts\SortStrategyInterface|null
     */
    public function fromArray(array $query, SortStrategyInterface $current = null);

    /**
     * Creates a new strategy from decoded query string.
     * 
     * @param  array  $query
     * @return \App\Service\Strategy\Contracts\SortStrategyInterface|null
     */
    public function fromDecodeQueryString(array $query);

    /**
     * Make a new strategy based type and sortOrder.
     * 
     * @param  string $type
     * @param  string $sortOrder
     * @throws \App\Service\Exception\BindingResolutionException
     * @return mixed
     */
    public function make($key, $sortOrder);
}
