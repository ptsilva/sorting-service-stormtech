<?php

namespace Tests\Unit\Service\Comparator;

use App\Service\Comparator\NumberComparator;

/**
 * IntegerComparatorTest.
 *
 * @group group
 */
class NumberComparatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider numberProvider
     * @covers \App\Service\Comparator\NumberComparator::compare
     * @return [type] [description]
     */
    public function testCompareBeetweenNumbers($firstItem, $secondItem, $expected)
    {
        $comparator = new NumberComparator();

        $this->assertEquals($expected, $comparator->compare($firstItem, $secondItem));
    }

    public function numberProvider()
    {
        return [
            [2010, 2010, 0],
            [2010, 2011, -1],
            [2011, 2010, 1],
        ];
    }
}
