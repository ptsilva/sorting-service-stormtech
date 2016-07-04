<?php

namespace Tests\Unit\Service\Exception;

use App\Service\Exception\FactoryParserException;
use Mockery as m;

/**
 * FactoryParseExceptionTest.
 *
 * @group group
 */
class FactoryParseExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testRegisterAndMakeParser()
    {
        $factory = new FactoryParserException();
        $mockResolver = m::mock('ParserResolver');
        $mime = 'application/xml';

        $this->assertSame($factory, $factory->registerParser($mime, $mockResolver));

        $this->assertInstanceOf(get_class($mockResolver), $factory->make('application/xml'));
    }
}
