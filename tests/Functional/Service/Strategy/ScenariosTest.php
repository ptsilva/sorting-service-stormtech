<?php

namespace Tests\Functional\Strategy;

use App\Service\Sorter\Sorter;
use Tests\Unit\Service\Fixture;
use App\Service\Collection\Collection;
use App\Service\SortOrder\AscendingSort;
use App\Service\SortOrder\DescendingSort;
use App\Service\Strategy\TitleSortStrategy;
use App\Service\Strategy\AuthorSortStrategy;
use App\Service\Comparator\StringComparator;
use App\Service\Comparator\NumberComparator;
use App\Service\Strategy\EditionSortStrategy;

/**
 * StrategiesTest.
 *
 * @group scenarios
 */
class ScenariosTest extends \PHPUnit_Framework_TestCase
{
    public function testScenario1()
    {
        $titleStrategy = new TitleSortStrategy(new AscendingSort, new StringComparator);

        $sorter = new Sorter($titleStrategy);

        $collection = new Collection(Fixture::getBooks());

        $this->assertEquals([
            ['title' => 'Head First Design Patterns', 'author' => 'Elisabeth Freeman', 'editionYear' => 2004],
            ['title' => 'Internet & World Wide Web: How to Program', 'author' => 'Deitel & Deitel', 'editionYear' => 2007],
            ['title' => 'Java How to Program', 'author' => 'Deitel & Deitel', 'editionYear' => 2007],
            ['title' => 'Patterns of Enterprise Application Architecture', 'author' => 'Martin Fowler', 'editionYear' => 2002],
        ], $sorter->sort($collection));
    }

    public function testScenario2()
    {
        $authorStrategy = new AuthorSortStrategy(new AscendingSort, new StringComparator);

        $authorStrategy->setNextSortStrategy(new TitleSortStrategy(new DescendingSort, new StringComparator));

        $sorter = new Sorter($authorStrategy);

        $collection = new Collection(Fixture::getBooks());

        $this->assertEquals([
            ['title' => 'Java How to Program', 'author' => 'Deitel & Deitel', 'editionYear' => 2007],
            ['title' => 'Internet & World Wide Web: How to Program', 'author' => 'Deitel & Deitel', 'editionYear' => 2007],
            ['title' => 'Head First Design Patterns', 'author' => 'Elisabeth Freeman', 'editionYear' => 2004],
            ['title' => 'Patterns of Enterprise Application Architecture', 'author' => 'Martin Fowler', 'editionYear' => 2002],
        ], $sorter->sort($collection));
    }

    public function testScenario3()
    {
        $editionStrategy = new EditionSortStrategy(new DescendingSort, new NumberComparator());

        $authorStrategy = new AuthorSortStrategy(new AscendingSort, new StringComparator);

        $titleStrategy = new TitleSortStrategy(new AscendingSort, new StringComparator);

        $editionStrategy->setNextSortStrategy($authorStrategy->setNextSortStrategy($titleStrategy));

        $sorter = new Sorter($editionStrategy);

        $collection = new Collection(Fixture::getBooks());

        $this->assertEquals([
            ['title' => 'Internet & World Wide Web: How to Program', 'author' => 'Deitel & Deitel', 'editionYear' => 2007],
            ['title' => 'Java How to Program', 'author' => 'Deitel & Deitel', 'editionYear' => 2007],
            ['title' => 'Head First Design Patterns', 'author' => 'Elisabeth Freeman', 'editionYear' => 2004],
            ['title' => 'Patterns of Enterprise Application Architecture', 'author' => 'Martin Fowler', 'editionYear' => 2002],
        ], $sorter->sort($collection));
    }

    /**
     * @expectedException \App\Service\Sorter\Exception\SortingServiceException
     */
    public function testScenario4()
    {
        $sorter = new Sorter();
        $sorter->sort(new Collection(null));
    }

    public function testScenario5()
    {
        $sorter = new Sorter();
        $this->assertEmpty($sorter->sort(new Collection([])));
    }
}
