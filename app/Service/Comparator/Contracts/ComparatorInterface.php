<?php

namespace App\Service\Comparator\Contracts;

interface ComparatorInterface
{
    /**
     * Compares two arguments.
     * 
     * @param  mixed $firstItem
     * @param  mixed $secondItem
     * @return int
     */
    public function compare($firstItem, $secondItem);
}
