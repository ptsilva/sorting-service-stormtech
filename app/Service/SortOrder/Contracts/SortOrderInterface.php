<?php

namespace App\Service\SortOrder\Contracts;

interface SortOrderInterface
{
    /**
     * Returns the numerical representation to sort order.
     *
     * @return int
     */
    public function getOrder();
}
