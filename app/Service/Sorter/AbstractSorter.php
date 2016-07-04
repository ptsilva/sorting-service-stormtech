<?php

namespace App\Service\Sorter;

use App\Service\Collection\Contracts\CollectionInterface;
use App\Service\Strategy\Contracts\SortStrategyInterface;
use App\Service\Sorter\Exception\SortingServiceException as ServiceException;

abstract class AbstractSorter
{
    /**
     * Strategy used to sort the elements.
     * 
     * @var \App\Service\Strategy\Contracts\SortStrategyInterface
     */
    protected $strategy;

    /**
     * Sort the collection elements.
     * 
     * @param \App\Service\Collection\CollectionInterface $collection
     * @throws \App\Service\Sorter\Exception\SortingServiceException
     * @return array
     */
    public function sort(CollectionInterface $collection)
    {
        if (is_null($this->strategy) && is_null($collection->all())) {
            throw new ServiceException('Invalid null strategy');
        }

        $items = $collection->all();

        if (! empty($items)) {
            usort($items, $this->strategy->prepare());
        }

        return $items;
    }

    /**
     * Sets the strategy used to sort the elements.
     * 
     * @param \App\Service\Strategy\Contracts\SortStrategyInterface
     * @return $this
     */
    public function setSortStrategy(SortStrategyInterface $strategy = null)
    {
        $this->strategy = $strategy;

        return $this;
    }

    /**
     * Returns current strategy.
     * 
     * @param \App\Service\Strategy\Contracts\SortStrategyInterface
     * @return $this
     */
    public function getSortStrategy()
    {
        return $this->strategy;
    }
}
