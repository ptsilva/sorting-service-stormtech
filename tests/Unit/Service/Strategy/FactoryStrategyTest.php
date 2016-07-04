<?php

namespace Tests\Unit\Service\Strategy;

use App\Service\Strategy\FactoryStrategy;
use Mockery as m;

/**
 * FactoryStrategyTest.
 *
 * @group group
 */
class FactoryStrategyTest extends \PHPUnit_Framework_TestCase
{
    public function testRegisterStrategy()
    {
        $factorySortOrder = m::mock('App\Service\SortOrder\Contracts\FactorySortOrderInterface');
        $factoryComparator = m::mock('App\Service\Comparator\Contracts\FactoryComparatorInterface');

        $factory = new FactoryStrategy($factorySortOrder, $factoryComparator);

        $this->assertSame($factory, $factory->registerStrategy('title', 'TitleSortStrategy', 'string'));

        $this->assertAttributeCount(1, 'registered', $factory);
    }

    public function testMake()
    {
        m::mock('AuthorSortStrategy');

        $factorySortOrder = m::mock('App\Service\SortOrder\Contracts\FactorySortOrderInterface')
            ->shouldReceive('make')->with('asc')->mock();
        $factoryComparator = m::mock('App\Service\Comparator\Contracts\FactoryComparatorInterface')
            ->shouldReceive('make')->with('string')->mock();

        $factory = new FactoryStrategy($factorySortOrder, $factoryComparator);

        $factory->registerStrategy('author', 'AuthorSortStrategy', 'string');

        $this->assertInstanceOf('AuthorSortStrategy', $factory->make('author', 'asc'));
    }

    public function testShouldLoadEnvConfigWhenEmptyDecodedQueryString()
    {
        putenv('DEFAULT_STRATEGY=author,asc');

        $authorMock = m::mock('AuthorSortStrategy');

        $factorySortOrder = m::mock('App\Service\SortOrder\Contracts\FactorySortOrderInterface')
            ->shouldReceive('make')->with('asc')->mock();
        $factoryComparator = m::mock('App\Service\Comparator\Contracts\FactoryComparatorInterface')
            ->shouldReceive('make')->with('string')->mock();

        $factory = new FactoryStrategy($factorySortOrder, $factoryComparator);

        $factory->registerStrategy('author', 'AuthorSortStrategy', 'string');

        $strategy = $factory->fromDecodeQueryString([]);

        $this->assertInstanceOf('AuthorSortStrategy', $strategy);
    }

    public function testFromPopulatedDecodedQueryString()
    {
        $authorMock = m::mock('AuthorSortStrategy');

        $factorySortOrder = m::mock('App\Service\SortOrder\Contracts\FactorySortOrderInterface')
            ->shouldReceive('make')->with('asc')->mock();
        $factoryComparator = m::mock('App\Service\Comparator\Contracts\FactoryComparatorInterface')
            ->shouldReceive('make')->with('string')->mock();

        $factory = new FactoryStrategy($factorySortOrder, $factoryComparator);

        $factory->registerStrategy('author', 'AuthorSortStrategy', 'string');

        $strategy = $factory->fromDecodeQueryString(['author' => 'asc']);

        $this->assertInstanceOf('AuthorSortStrategy', $strategy);
    }

    public function testfromArray()
    {
        $editionYearMock = m::mock('EditionYearSortStrategy');

        $titleMock = m::mock('TitleSortStrategy')
        ->shouldReceive('setNextSortStrategy')->with($editionYearMock)->mock();

        $authorMock = m::mock('AuthorSortStrategy')
            ->shouldReceive('setNextSortStrategy')->with($titleMock)->mock();

        $factorySortOrder = m::mock('App\Service\SortOrder\Contracts\FactorySortOrderInterface')
            ->shouldReceive('make')->with('asc')->mock();
        $factoryComparator = m::mock('App\Service\Comparator\Contracts\FactoryComparatorInterface')
            ->shouldReceive('make')->with('string')->mock();

        $factory = new FactoryStrategy($factorySortOrder, $factoryComparator);

        $factory->registerStrategy('author', $authorMock, 'string');

        $factory->registerStrategy('title', $titleMock, 'string');

        $factory->registerStrategy('editionYear', $editionYearMock, 'string');

        $strategy = $factory->fromArray(['author' => 'asc', 'title' => 'asc', 'editionYear' => 'asc']);

        $this->assertInstanceOf('AuthorSortStrategy', $strategy);
    }

    /**
     * @expectedException \App\Service\Exception\BindingResolutionException
     */
    public function testShouldThrowExceptionWhenInvalidArgumentToMakeStrategy()
    {
        $factorySortOrder = m::mock('App\Service\SortOrder\Contracts\FactorySortOrderInterface');
        $factoryComparator = m::mock('App\Service\Comparator\Contracts\FactoryComparatorInterface');

        $factory = new FactoryStrategy($factorySortOrder, $factoryComparator);

        $factory->make('author', 'asc');
    }
}
