<?php

namespace Tests\Unit\Service\Collection;

use Tests\Unit\Service\Fixture;
use App\Service\Collection\Collection;

/**
 * CollectionTest.
 *
 * @group group
 */
class CollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \App\Service\Collection\Collection::all
     */
    public function testGetAllElementsFromCollection()
    {
        $books = Fixture::getBooks();

        $collection = new Collection($books);

        $this->assertEquals($books, $collection->all());
    }

    public function testSetItemsCollection()
    {
        $books = Fixture::getBooks();

        $collection = new Collection();

        $collection->setItems($books);

        $this->assertEquals($books, $collection->all());
    }
}
