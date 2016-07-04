<?php

namespace App\Service\Sorter\Contracts;

use App\Service\Strategy\Contracts\SortStrategyInterface;
use App\Service\Collection\Contracts\CollectionInterface;

interface SorterInterface
{
    /**
     * Sort the collection elements.
     * 
     * @param \App\Service\Collection\CollectionInterface $collection
     *
     * @return array
     */
    public function sort(CollectionInterface $collection);

    /**
     * Sets the strategy used to sort the elements.
     * 
     * @param \App\Service\Strategy\Contracts\SortStrategyInterface
     * @return $this
     */
    public function setSortStrategy(SortStrategyInterface $strategy);

    /**
     * Returns the strategy setted to sorter.
     * 
     * @return \App\Service\Strategy\Contracts\SortStrategyInterface
     */
    public function getSortStrategy();
}
