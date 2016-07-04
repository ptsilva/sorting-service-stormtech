<?php

namespace App\Service\Sorter;

use App\Service\Sorter\Contracts\SorterInterface;
use App\Service\Strategy\Contracts\SortStrategyInterface;

class Sorter extends AbstractSorter implements SorterInterface
{
    /**
     * Create a new sorter.
     *
     * @param  \App\Service\Strategy\Contracts\SortStrategyInterface $strategy
     * @return void
     */
    public function __construct(SortStrategyInterface $strategy = null)
    {
        $this->strategy = $strategy;
    }
}
