<?php

namespace Tests\Unit\Service\SortOrder;

use App\Service\SortOrder\AscendingSort;

/**
 * AscendingTest.
 *
 * @group group
 */
class AscendingOrderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \App\Service\SortOrder\AscendingSort::getOrder
     */
    public function testGetOrder()
    {
        $order = new AscendingSort();
        $this->assertEquals(1, $order->getOrder());
    }
}
