<?php

namespace App\Service\Collection;

use App\Service\Collection\Contracts\CollectionInterface;

class Collection implements CollectionInterface
{
    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected $items;

    /**
     * Create a new collection.
     *
     * @param  mixed  $items
     * @return void
     */
    public function __construct($items = [])
    {
        $this->items = $items;
    }

    /**
     * Get all of the items in the collection.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Set new items to collection.
     * @param mixed $items
     * @return  $this
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }
}
