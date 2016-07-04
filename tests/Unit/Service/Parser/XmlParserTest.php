<?php

namespace Tests\Unit\Service\Parser;

use App\Service\Parser\XmlParser;
use Tests\Unit\Service\Fixture;

class XmlParserTest extends \PHPUnit_Framework_TestCase
{
    public function testDecode()
    {
        $rawBooks = Fixture::getBooks();
        $books = <<<XML
<?xml version="1.0"?>
        <data>
           <book>
                <title>Java How to Program</title>
                <author>Deitel &amp; Deitel</author>
                <editionYear>2007</editionYear>
           </book>
           <book>
                <title>Patterns of Enterprise Application Architecture</title>
                <author>Martin Fowler</author>
                <editionYear>2002</editionYear>
           </book>
           <book>
                <title>Head First Design Patterns</title>
                <author>Elisabeth Freeman</author>
                <editionYear>2004</editionYear>
           </book>
           <book>
                <title>Internet &amp; World Wide Web: How to Program</title>
                <author>Deitel &amp; Deitel</author>
                <editionYear>2007</editionYear>
            </book>
        </data>
XML;

        $parser = new XmlParser();

        $this->assertEquals($rawBooks, $parser->decode($books));
    }

    public function testEncode()
    {
        $rawBooks = Fixture::getBooks();
        $expectedValue = <<<XML
<?xml version="1.0"?>
<data>
  <book>
    <title>Java How to Program</title>
    <author>Deitel &amp; Deitel</author>
    <editionYear>2007</editionYear>
  </book>
  <book>
    <title>Patterns of Enterprise Application Architecture</title>
    <author>Martin Fowler</author>
    <editionYear>2002</editionYear>
  </book>
  <book>
    <title>Head First Design Patterns</title>
    <author>Elisabeth Freeman</author>
    <editionYear>2004</editionYear>
  </book>
  <book>
    <title>Internet &amp; World Wide Web: How to Program</title>
    <author>Deitel &amp; Deitel</author>
    <editionYear>2007</editionYear>
  </book>
</data>
XML;

        $parser = new XmlParser();

        $this->assertXmlStringEqualsXmlString($expectedValue, $parser->encode($rawBooks));
    }
}
