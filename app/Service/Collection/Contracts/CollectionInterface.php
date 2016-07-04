<?php

namespace App\Service\Collection\Contracts;

interface CollectionInterface
{
    /**
     * Get all of the items in the collection.
     *
     * @return array
     */
    public function all();

    public function setItems($items);
}
