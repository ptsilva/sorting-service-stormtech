<?php

namespace Tests\Unit\Service\Strategy;

use App\Service\Strategy\TitleSortStrategy;
use Tests\Unit\Service\Fixture;
use Mockery as m;

/**
 * TitleSortStrategyTest.
 */
class TitleSortStrategyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \App\Service\Strategy\TitleSortStrategy::setNextSortStrategy
     * @covers \App\Service\Strategy\TitleSortStrategy::nextSortStrategy
     */
    public function testPrepareMethodShouldMakeCallableComparator()
    {
        $inputValue = Fixture::getBooks();

        $expectedValue = [
            ['title' => 'Head First Design Patterns', 'author' => 'Elisabeth Freeman', 'editionYear' => '2004'],
            ['title' => 'Internet & World Wide Web: How to Program', 'author' => 'Deitel & Deitel', 'editionYear' => '2007'],
            ['title' => 'Java How to Program', 'author' => 'Deitel & Deitel', 'editionYear' => '2007'],
            ['title' => 'Patterns of Enterprise Application Architecture', 'author' => 'Martin Fowler', 'editionYear' => '2002'],
        ];

        $sortOrder = m::mock('App\Service\SortOrder\Contracts\SortOrderInterface')
        ->shouldReceive('getOrder')->andReturn(1)->mock();

        $comparator = m::mock('App\Service\Comparator\Contracts\ComparatorInterface')
        ->shouldReceive('compare')->andReturnUsing(function ($firstItem, $secondItem) {
            return strcmp($firstItem, $secondItem);
        })->mock();

        $titleStrategy = new TitleSortStrategy($sortOrder, $comparator);
        $callable = $titleStrategy->prepare($inputValue);

        usort($inputValue, $callable);

        $this->assertEquals($expectedValue, $inputValue);
    }

    public function testGetSetNextSortStrategy()
    {
        $sortOrder = m::mock('App\Service\SortOrder\Contracts\SortOrderInterface');
        $comparator = m::mock('App\Service\Comparator\Contracts\ComparatorInterface');
        $nextStrategy = m::mock('App\Service\Strategy\Contracts\SortStrategyInterface');

        $authorSortStrategy = new TitleSortStrategy($sortOrder, $comparator);

        //chaining
        $this->assertSame($authorSortStrategy, $authorSortStrategy->setNextSortStrategy($nextStrategy));
        $this->assertSame($nextStrategy, $authorSortStrategy->nextSortStrategy());
    }

    /**
     * @covers \App\Service\Strategy\TitleSortStrategy::setNextSortStrategy
     * @covers \App\Service\Strategy\TitleSortStrategy::nextSortStrategy
     */
    public function testGetSetComparator()
    {
        $sortOrder = m::mock('App\Service\SortOrder\Contracts\SortOrderInterface');
        $comparator = m::mock('App\Service\Comparator\Contracts\ComparatorInterface');

        $authorSortStrategy = new TitleSortStrategy($sortOrder, $comparator);

        $newComparator = m::mock('App\Service\Comparator\Contracts\ComparatorInterface');

        //chaining
        $this->assertSame($authorSortStrategy, $authorSortStrategy->setComparator($newComparator));
        $this->assertSame($newComparator, $authorSortStrategy->getComparator());
    }

    /**
     * @covers \App\Service\Strategy\TitleSortStrategy::setNextSortStrategy
     * @covers \App\Service\Strategy\TitleSortStrategy::nextSortStrategy
     */
    public function testHasNextSortStrategy()
    {
        $sortOrder = m::mock('App\Service\SortOrder\Contracts\SortOrderInterface');
        $comparator = m::mock('App\Service\Comparator\Contracts\ComparatorInterface');
        $nextStrategy = m::mock('App\Service\Strategy\Contracts\SortStrategyInterface');

        $authorSortStrategy = new TitleSortStrategy($sortOrder, $comparator);

        $this->assertFalse($authorSortStrategy->hasNextSortStrategy());

        $authorSortStrategy->setNextSortStrategy($nextStrategy);

        $this->assertTrue($authorSortStrategy->hasNextSortStrategy());
    }

    /**
     * @covers \App\Service\Strategy\TitleSortStrategy::setNextSortStrategy
     * @covers \App\Service\Strategy\TitleSortStrategy::nextSortStrategy
     */
    public function testChainedSortStrategy()
    {
        $inputValue = Fixture::getBooks();

        $expectedValue = [
            ['title' => 'Head First Design Patterns', 'author' => 'Elisabeth Freeman', 'editionYear' => 2004],
            ['title' => 'Internet & World Wide Web: How to Program', 'author' => 'Deitel & Deitel', 'editionYear' => 2007],
            ['title' => 'Java How to Program', 'author' => 'Deitel & Deitel', 'editionYear' => 2007],
            ['title' => 'Patterns of Enterprise Application Architecture', 'author' => 'Martin Fowler', 'editionYear' => 2002],
        ];

        $sortOrder = m::mock('App\Service\SortOrder\Contracts\SortOrderInterface')
        ->shouldReceive('getOrder')->andReturn(1)->mock();

        $comparator = m::mock('App\Service\Comparator\Contracts\ComparatorInterface')
        ->shouldReceive('compare')->andReturnUsing(function ($firstItem, $secondItem) {
            return strcmp($firstItem, $secondItem);
        })->mock();

        $nextStrategy = m::mock('App\Service\Strategy\Contracts\SortStrategyInterface')
        ->shouldReceive('prepare')->andReturn(function ($firstItem, $secondItem) {
            return strcmp($firstItem['author'], $secondItem['author']) * -1; //Descending order
        })->mock();

        $authorSortStrategy = new TitleSortStrategy($sortOrder, $comparator);
        $authorSortStrategy->setNextSortStrategy($nextStrategy);

        usort($inputValue, $authorSortStrategy->prepare());

        $this->assertEquals($expectedValue, $inputValue);
    }
}
