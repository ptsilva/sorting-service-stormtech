<?php

namespace Tests\Unit\Service\Sorter;

use App\Service\Sorter\Sorter;
use Mockery as m;

/**
 * 
 */
class SorterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \App\Service\Sorter\Sorter::sort
     * @expectedException \App\Service\Sorter\Exception\SortingServiceException
     */
    public function testThrowSortingServiceExceptionWhenSortStrategyIsNull()
    {
        $collection = m::mock('App\Service\Collection\Contracts\CollectionInterface')
            ->shouldReceive('all')->once()->andReturn(null)->mock();

        $sorter = new Sorter();
        $sorter->sort($collection);
    }

    public function testShouldReceiveSortStrategyInterface()
    {
        $strategy = m::mock('App\Service\Strategy\Contracts\SortStrategyInterface');

        new Sorter($strategy);
    }

    /**
     * @covers \App\Service\Sorter\Sorter::sort
     */
    public function testShouldUseStrategyToSort()
    {
        $inputValue = [3, 2, 1];
        $expectedValue = [1, 2, 3];

        $strategy = m::mock('App\Service\Strategy\Contracts\SortStrategyInterface')
            ->shouldReceive('prepare')->once()->andReturn(function ($firstItem, $secondItem) {
                return strcmp($firstItem, $secondItem);
            })->mock();

        $collection = m::mock('App\Service\Collection\Contracts\CollectionInterface')
            ->shouldReceive('all')->once()->andReturn($inputValue)->mock();

        $sorter = new Sorter($strategy);

        $this->assertEquals($expectedValue, $sorter->sort($collection));
    }

    /**
     * @covers \App\Service\Sorter\Sorter::getSortStrategy
     * @covers \App\Service\Sorter\Sorter::setSortStrategy
     */
    public function testGetSetSortStrategy()
    {
        $strategy = m::mock('App\Service\Strategy\Contracts\SortStrategyInterface');

        $sorter = new Sorter();

        //chaining
        $this->assertSame($sorter, $sorter->setSortStrategy($strategy));

        $this->assertSame($strategy, $sorter->getSortStrategy());
    }
}
