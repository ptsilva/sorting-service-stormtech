<?php

namespace Tests\Unit\Service\Exception;

use Mockery as m;
use App\Service\Exception\XmlParserException;

/**
 * XmlParserExceptionTest.
 *
 * @group group
 */
class XmlParserExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $expectedMessage = 'message exception';

        $exception = m::mock('App\Service\Exception\Contracts\ParseableExceptionInterface')
        ->shouldReceive('getMessage')->andReturn($expectedMessage)->mock();

        $expectedException = get_class($exception);
        $expectedResult = <<<XML
<?xml version="1.0"?>
<error>
  <exception>$expectedException</exception>
  <messsage>$expectedMessage</messsage>
</error>
XML;

        $parser = new XmlParserException();

        $this->assertXmlStringEqualsXmlString($expectedResult, $parser->parse($exception));
    }
}
