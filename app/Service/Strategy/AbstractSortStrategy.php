<?php

namespace App\Service\Strategy;

use App\Service\SortOrder\Contracts\SortOrderInterface;
use App\Service\Comparator\Contracts\ComparatorInterface;
use App\Service\Strategy\Contracts\SortStrategyInterface;

abstract class AbstractSortStrategy
{
    /**
     * Sort order.
     * @var \App\Service\SortOrder\Contracts\SortOrderInterface
     */
    protected $sortOrder;

    /**
     * Comparator used to verify the property.
     * 
     * @var \App\Service\Comparator\Contracts\ComparatorInterface
     */
    protected $comparator;

    /**
     * Chained strategy to check when this returns equals.
     * 
     * @var \App\Service\Strategy\Contracts\SortStrategyInterface
     */
    protected $nextStrategy;

    /**
     * Constructs the strategy.
     * 
     * @param \App\Service\SortOrder\Contracts\SortOrderInterface  $sortOrder
     * @param \App\Service\Comparator\Contracts\ComparatorInterface $comparator
     */
    public function __construct(SortOrderInterface $sortOrder, ComparatorInterface $comparator)
    {
        $this->sortOrder = $sortOrder;
        $this->comparator = $comparator;
    }

    /**
     * Make callable used to sort items.
     * 
     * @return callable
     */
    public function prepare()
    {
        $property = $this->accessProperty();
        $sortOrder = $this->sortOrder->getOrder();
        $comparator = $this->getComparator();
        $sortStrategy = $this;

        return function ($firstItem, $secondItem) use ($property, $sortOrder, $comparator, $sortStrategy) {
            $result = $comparator->compare($firstItem[$property], $secondItem[$property]) * $sortOrder;
            if (0 == $result && $sortStrategy->hasNextSortStrategy()) {
                $nextStrategy = $sortStrategy->nextSortStrategy();
                $callback = $nextStrategy->prepare();
                $result = $callback($firstItem, $secondItem);
            }

            return $result;
        };
    }

    /**
     * Check if has chained strategy.
     * 
     * @return bool
     */
    public function hasNextSortStrategy()
    {
        return ! is_null($this->nextStrategy);
    }

    /**
     * Returns the next chained strategy.
     * 
     * @return \App\Service\Strategy\Contracts\SortStrategyInterface
     */
    public function nextSortStrategy()
    {
        return $this->nextStrategy;
    }

    /**
     * Sets the strategy in chain execution.
     * 
     * @param \App\Service\Strategy\Contracts\SortStrategyInterface $strategy
     * @return $this
     */
    public function setNextSortStrategy(SortStrategyInterface $strategy)
    {
        $this->nextStrategy = $strategy;

        return $this;
    }

    /**
     * Returns the comparator.
     * 
     * @return \App\Service\Comparator\Contracts\ComparatorInterface
     */
    public function getComparator()
    {
        return $this->comparator;
    }

    /**
     * Set the comparator used in strategy.
     * 
     * @param \App\Service\Comparator\Contracts\ComparatorInterface $comparator
     */
    public function setComparator(ComparatorInterface $comparator)
    {
        $this->comparator = $comparator;

        return $this;
    }

    /**
     * Defines the property check.
     * @return string
     */
    abstract public function accessProperty();
}
