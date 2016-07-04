<?php

namespace App\Service\SortOrder;

use App\Service\SortOrder\Contracts\SortOrderInterface;

class AscendingSort implements SortOrderInterface
{
    /**
     * Returns the numerical representation to sort order.
     *
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
