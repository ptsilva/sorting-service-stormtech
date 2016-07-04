<?php

namespace Tests\Unit\Service\Strategy;

use App\Service\Strategy\EditionSortStrategy;
use Tests\Unit\Service\Fixture;
use Mockery as m;

/**
 * TitleSortStrategyTest.
 */
class EditionSortStrategyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \App\Service\Strategy\EditionSortStrategy::prepare
     */
    public function testPrepareMethodShouldMakeCallableComparator()
    {
        $inputValue = Fixture::getBooks();

        $expectedValue = [
            ['title' => 'Patterns of Enterprise Application Architecture', 'author' => 'Martin Fowler', 'editionYear' => '2002'],
            ['title' => 'Head First Design Patterns', 'author' => 'Elisabeth Freeman', 'editionYear' => '2004'],
            ['title' => 'Internet & World Wide Web: How to Program', 'author' => 'Deitel & Deitel', 'editionYear' => '2007'],
            ['title' => 'Java How to Program', 'author' => 'Deitel & Deitel', 'editionYear' => '2007'],
        ];

        $sortOrder = m::mock('App\Service\SortOrder\Contracts\SortOrderInterface')
        ->shouldReceive('getOrder')->andReturn(1)->mock();

        $comparator = m::mock('App\Service\Comparator\Contracts\ComparatorInterface')
        ->shouldReceive('compare')->andReturnUsing(function ($firstItem, $secondItem) {
            return strcmp($firstItem, $secondItem);
        })->mock();

        $titleStrategy = new EditionSortStrategy($sortOrder, $comparator);
        $callable = $titleStrategy->prepare($inputValue);

        usort($inputValue, $callable);

        $this->assertEquals($expectedValue, $inputValue);
    }

    /**
     * @covers \App\Service\Strategy\EditionSortStrategy::setNextSortStrategy
     * @covers \App\Service\Strategy\EditionSortStrategy::nextSortStrategy
     */
    public function testGetSetNextSortStrategy()
    {
        $sortOrder = m::mock('App\Service\SortOrder\Contracts\SortOrderInterface');
        $comparator = m::mock('App\Service\Comparator\Contracts\ComparatorInterface');
        $nextStrategy = m::mock('App\Service\Strategy\Contracts\SortStrategyInterface');

        $authorSortStrategy = new EditionSortStrategy($sortOrder, $comparator);

        //chaining
        $this->assertSame($authorSortStrategy, $authorSortStrategy->setNextSortStrategy($nextStrategy));
        $this->assertSame($nextStrategy, $authorSortStrategy->nextSortStrategy());
    }

    /**
     * @covers \App\Service\Strategy\EditionSortStrategy::hasNextSortStrategy
     * @covers \App\Service\Strategy\EditionSortStrategy::setNextSortStrategy
     */
    public function testHasNextSortStrategy()
    {
        $sortOrder = m::mock('App\Service\SortOrder\Contracts\SortOrderInterface');
        $comparator = m::mock('App\Service\Comparator\Contracts\ComparatorInterface');
        $nextStrategy = m::mock('App\Service\Strategy\Contracts\SortStrategyInterface');

        $authorSortStrategy = new EditionSortStrategy($sortOrder, $comparator);

        $this->assertFalse($authorSortStrategy->hasNextSortStrategy());

        $authorSortStrategy->setNextSortStrategy($nextStrategy);

        $this->assertTrue($authorSortStrategy->hasNextSortStrategy());
    }

    /**
     * @covers \App\Service\Strategy\EditionSortStrategy::setComparator
     * @covers \App\Service\Strategy\EditionSortStrategy::getComparator
     */
    public function testGetSetComparator()
    {
        $sortOrder = m::mock('App\Service\SortOrder\Contracts\SortOrderInterface');
        $comparator = m::mock('App\Service\Comparator\Contracts\ComparatorInterface');

        $authorSortStrategy = new EditionSortStrategy($sortOrder, $comparator);

        $newComparator = m::mock('App\Service\Comparator\Contracts\ComparatorInterface');

        //chaining
        $this->assertSame($authorSortStrategy, $authorSortStrategy->setComparator($newComparator));
        $this->assertSame($newComparator, $authorSortStrategy->getComparator());
    }

    /**
     * @covers \App\Service\Strategy\EditionSortStrategy::setNextSortStrategy
     * @covers \App\Service\Strategy\EditionSortStrategy::prepare
     */
    public function testChainedSortStrategy()
    {
        $inputValue = Fixture::getBooks();

        $expectedValue = [
            ['title' => 'Patterns of Enterprise Application Architecture', 'author' => 'Martin Fowler', 'editionYear' => 2002],
            ['title' => 'Head First Design Patterns', 'author' => 'Elisabeth Freeman', 'editionYear' => 2004],
            ['title' => 'Java How to Program', 'author' => 'Deitel & Deitel', 'editionYear' => 2007],
            ['title' => 'Internet & World Wide Web: How to Program', 'author' => 'Deitel & Deitel', 'editionYear' => 2007],
        ];

        $sortOrder = m::mock('App\Service\SortOrder\Contracts\SortOrderInterface')
        ->shouldReceive('getOrder')
        ->andReturn(1)
        ->mock();

        $comparator = m::mock('App\Service\Comparator\Contracts\ComparatorInterface')
        ->shouldReceive('compare')->andReturnUsing(function ($firstItem, $secondItem) {
            return strcmp($firstItem, $secondItem);
        })->mock();

        $nextStrategy = m::mock('App\Service\Strategy\Contracts\SortStrategyInterface')
        ->shouldReceive('prepare')->andReturn(function ($firstItem, $secondItem) {
            return strcmp($firstItem['title'], $secondItem['title']) * -1; //Descending order
        })->mock();

        $authorSortStrategy = new EditionSortStrategy($sortOrder, $comparator);
        $authorSortStrategy->setNextSortStrategy($nextStrategy);

        usort($inputValue, $authorSortStrategy->prepare());

        $this->assertEquals($expectedValue, $inputValue);
    }
}
