<?php

namespace Tests\Unit\Service\SortOrder;

use App\Service\SortOrder\DescendingSort;

/**
 * AscendingTest.
 *
 * @group group
 */
class DescendingSortTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \App\Service\SortOrder\DescendingSort::getOrder
     */
    public function testGetOrder()
    {
        $order = new DescendingSort();
        $this->assertEquals(-1, $order->getOrder());
    }
}
