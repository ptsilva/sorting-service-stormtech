<?php

namespace Tests\Unit\Service\SortOrder;

use App\Service\SortOrder\FactorySortOrder;
use Mockery as m;

/**
 * FactorySortOrderTest.
 *
 * @group group
 */
class FactorySortOrderTest extends \PHPUnit_Framework_TestCase
{
    public function testRegisterSortOrder()
    {
        $factory = new FactorySortOrder();

        $this->assertSame($factory, $factory->registerSortOrder('asc', 'AscClass'));

        $this->assertAttributeCount(1, 'registered', $factory);
    }

    public function testMake()
    {
        $factory = new FactorySortOrder();

        m::mock('AscClass');

        $factory->registerSortOrder('asc', 'AscClass');

        $this->assertInstanceOf('AscClass', $factory->make('asc'));
    }

    /**
     * @expectedException \App\Service\Exception\BindingResolutionException
     */
    public function testShouldThrowExceptionWhenInvalidArgumentToMakeSortOrder()
    {
        $factory = new FactorySortOrder();

        $factory->make('asc');
    }
}
