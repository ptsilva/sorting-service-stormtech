<?php

namespace App\Service\Strategy;

use App\Service\Strategy\Contracts\SortStrategyInterface;

class EditionSortStrategy extends AbstractSortStrategy implements SortStrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function accessProperty()
    {
        return 'editionYear';
    }
}
