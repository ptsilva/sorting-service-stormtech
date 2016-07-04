<?php

namespace App\Service\Strategy;

use App\Service\Strategy\Contracts\SortStrategyInterface;

class TitleSortStrategy extends AbstractSortStrategy implements SortStrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function accessProperty()
    {
        return 'title';
    }
}
