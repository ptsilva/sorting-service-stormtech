<?php

namespace App\Service\Strategy;

use App\Service\Strategy\Contracts\SortStrategyInterface;

class AuthorSortStrategy extends AbstractSortStrategy implements SortStrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function accessProperty()
    {
        return 'author';
    }
}
