<?php

namespace App\Service\SortOrder;

use App\Service\Exception\BindingResolutionException;
use App\Service\SortOrder\Contracts\FactorySortOrderInterface;

class FactorySortOrder implements FactorySortOrderInterface
{
    /**
     * Registered comparators in factory.
     * 
     * @var array
     */
    protected $registered;

    /**
     * Register new sort order in factory.
     * 
     * @param  string $key
     * @param  string $sortOrder
     * @return $this
     */
    public function registerSortOrder($key, $sortOrder)
    {
        $this->registered[$key] = $sortOrder;

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
            throw new BindingResolutionException("Sort order {$key} is not registered");
        }

        return new $this->registered[$key];
    }
}
