<?php

namespace App\Service\SortOrder\Contracts;

interface FactorySortOrderInterface
{
    /**
     * Register new SortOrder in factory.
     * @param  string $key
     * @param  string $sortOrder
     * @return $this
     */
    public function registerSortOrder($key, $sortOrder);

    /**
     * Resolves dependency based the key.
     * @param  string $key
     * @return mixed
     */
    public function make($key);
}
