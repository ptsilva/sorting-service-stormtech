<?php

namespace App\Service\Strategy\Contracts;

use App\Service\Comparator\Contracts\ComparatorInterface;

interface SortStrategyInterface
{
    /**
     * Make callable used to sort items.
     * 
     * @return callable
     */
    public function prepare();

    /**
     * Check if has chained strategy.
     * 
     * @return bool
     */
    public function hasNextSortStrategy();

    /**
     * Returns the next chained strategy.
     * 
     * @return \App\Service\Strategy\Contracts\SortStrategyInterface
     */
    public function nextSortStrategy();

    /**
     * Sets the strategy in chain execution.
     * 
     * @param \App\Service\Strategy\Contracts\SortStrategyInterface $strategy
     * @return $this
     */
    public function setNextSortStrategy(SortStrategyInterface $strategy);

    /**
     * Returns the comparator.
     * 
     * @return \App\Service\Comparator\Contracts\ComparatorInterface
     */
    public function getComparator();

    /**
     * Set the comparator used in strategy.
     * 
     * @param \App\Service\Comparator\Contracts\ComparatorInterface
     */
    public function setComparator(ComparatorInterface $comparator);
}
