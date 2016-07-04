<?php

namespace Tests\Unit\Service\Parser;

use App\Service\Parser\JsonParser;
use Tests\Unit\Service\Fixture;

/**
 * JsonParserTest.
 *
 * @group group
 */
class JsonParserTest extends \PHPUnit_Framework_TestCase
{
    public function testDecode()
    {
        $rawBooks = Fixture::getBooks();
        $books = json_encode(['data' => $rawBooks]);

        $parser = new JsonParser();

        $this->assertEquals($rawBooks, $parser->decode($books));
    }

    public function testEncode()
    {
        $rawBooks = Fixture::getBooks();
        $encodedBooks = json_encode(['data' => $rawBooks]);

        $parser = new JsonParser();

        $this->assertEquals($encodedBooks, $parser->encode($rawBooks));
    }
}
