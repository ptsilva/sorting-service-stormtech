<?php

namespace App\Service\Comparator;

use App\Service\Comparator\Contracts\ComparatorInterface;

class NumberComparator implements ComparatorInterface
{
    /**
     * Compares two numeric values.
     * 
     * @param  int|float $firstItem
     * @param  int|float $secondItem
     * @return int
     */
    public function compare($firstItem, $secondItem)
    {
        $result = strcmp($firstItem, $secondItem);

        if($result == 0) {
            $result =  0;
        } else if ($result >= 1) {
            $result = 1;
        } else if($result <= -1) {
            $result = -1;
        }

        return $result;
    }
}
