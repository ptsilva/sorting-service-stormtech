<?php

namespace App\Service\Comparator\Contracts;

interface StringComparatorInterface extends ComparatorInterface
{
    /**
     * Set the comparator has insensitive.
     * 
     * @return $this
     */
    public function withInsensitive();

    /**
     * Set the comparator has sensitive.
     * 
     * @return $this
     */
    public function withSensitive();
}
