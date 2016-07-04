<?php

namespace Tests\Unit\Service\Comparator;

use App\Service\Comparator\StringComparator;

/**
 * StringComparatorTest.
 *
 * @group group
 */
class StringComparatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider comparWithInsensitiveDataProvider
     * @covers \App\Service\Comparator\StringComparator::withInsensitive
     * @covers \App\Service\Comparator\StringComparator::compare
     */
    public function testCompareWithInsensitive($firstItem, $secondItem, $expectedValue)
    {
        $comparator = (new StringComparator())->withInsensitive();

        $this->assertEquals($expectedValue, $comparator->compare($firstItem, $secondItem));
    }

    public function comparWithInsensitiveDataProvider()
    {
        return [
            ['a', 'a', 0],
            ['A', 'a', 0],
            ['a', 'A', 0],
        ];
    }

    /**
     * @dataProvider comparWithSensitiveDataProvider
     * @covers \App\Service\Comparator\StringComparator::withSensitive
     * @covers \App\Service\Comparator\StringComparator::compare
     */
    public function testCompareWithSensitive($firstItem, $secondItem, $expectedValue)
    {
        $comparator = (new StringComparator())->withSensitive();
        $this->assertEquals($expectedValue, $comparator->compare($firstItem, $secondItem));

        //Default sensitive style should be automatically set
        $comparator = new StringComparator();
        $this->assertEquals($expectedValue, $comparator->compare($firstItem, $secondItem));
    }

    public function comparWithSensitiveDataProvider()
    {
        return [
            ['a', 'a', 0],
            ['A', 'a', -1],
            ['a', 'A', 1],
        ];
    }
}
