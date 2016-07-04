<?php

namespace App\Service\Strategy;

use App\Service\Exception\BindingResolutionException;
use App\Service\Strategy\Contracts\SortStrategyInterface;
use App\Service\Strategy\Contracts\FactoryStrategyInterface;
use App\Service\SortOrder\Contracts\FactorySortOrderInterface;
use App\Service\Comparator\Contracts\FactoryComparatorInterface;

/**
 * 
 */
class FactoryStrategy implements FactoryStrategyInterface
{
    /**
     * Registered comparators in factory.
     * 
     * @var array
     */
    protected $registered = [];

    /**
     * Makes a new factory.
     * 
     * @param \App\Service\SortOrder\Contracts\FactorySortOrderInterface  $factorySortOrder
     * @param \App\Service\Comparator\Contracts\FactoryComparatorInterface $factoryComparator
     */
    public function __construct(FactorySortOrderInterface $factorySortOrder, FactoryComparatorInterface $factoryComparator)
    {
        $this->factorySortOrder = $factorySortOrder;
        $this->factoryComparator = $factoryComparator;
    }

    /**
     * Register a new strategy in factory.
     * 
     * @param  string $type
     * @param  string $strategy
     * @param  string $comparator
     * @return $this
     */
    public function registerStrategy($type, $strategy, $comparator)
    {
        $this->registered[$type] = [$strategy, $comparator];

        return $this;
    }

    /**
     * Make a new strategy based type and sortOrder.
     * 
     * @param  string $type
     * @param  string $sortOrder
     * @throws \App\Service\Exception\BindingResolutionException
     * @return mixed
     */
    public function make($type, $sortOrder)
    {
        if (! isset($this->registered[$type])) {
            throw new BindingResolutionException("The strategy {$type} is not registered");
        }

        $strategy = $this->registered[$type][0];
        $comparator = $this->registered[$type][1];

        $sortOrder = $this->factorySortOrder->make($sortOrder);
        $comparator = $this->factoryComparator->make($comparator);

        if (is_string($strategy)) {
            $strategy = new $strategy($sortOrder, $comparator);
        }

        return $strategy;
    }

    /**
     * Creates a new strategy from decoded query string.
     * 
     * @param  array  $query
     * @return \App\Service\Strategy\Contracts\SortStrategyInterface|null
     */
    public function fromDecodeQueryString(array $query)
    {
        if (empty($query)) {
            $strategy = $this->fromEnv();
        } else {
            $strategy = $this->fromArray($query);
        }

        return $strategy;
    }

    /**
     * Crates a new strategy from array.
     * 
     * @param  array $source
     * @param  \App\Service\Strategy\Contracts\SortStrategyInterface|null $current
     * @return \App\Service\Strategy\Contracts\SortStrategyInterface|null
     */
    public function fromArray(array $source, SortStrategyInterface $current = null)
    {
        $strategies = [];

        if (! empty($source)) {
            foreach ($source as $strategyDefinition => $sortOrder) {
                $strategies[] = $this->make($strategyDefinition, $sortOrder);
            }

            $current = array_shift($strategies);

            foreach ($strategies as $strategy) {
                $this->chainStrategies($current, $strategies);
            }
        }

        return $current;
    }

    /**
     * Crated a new strategy from env config.
     * 
     * @return \App\Service\Strategy\Contracts\SortStrategyInterface|null
     */
    public function fromEnv()
    {
        $strategies = [];
        $config = env('DEFAULT_STRATEGY', '');
        if ('' === $config) {
            return;
        }

        $envConfig = explode(',', $config);

        if (! empty($envConfig)) {
            $pairs = array_chunk($envConfig, 2);

            foreach ($pairs as $pair) {
                list($strategy, $sortOrder) = $pair;
                $strategies[$strategy] = $sortOrder;
            }
        }

        return $this->fromArray($strategies);
    }

    /**
     * Fill the next sort strategy recursively.
     * 
     * @param  \App\Service\Strategy\Contracts\SortStrategyInterface|null $current
     * @param  array $strategies
     * @return void
     */
    protected function chainStrategies($current, $strategies)
    {
        $next = array_shift($strategies);

        $current->setNextSortStrategy($next);
        if (count($strategies)) {
            $this->chainStrategies($next, $strategies);
        }
    }
}
