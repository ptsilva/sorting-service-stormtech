<?php

namespace Tests\Unit\Service\Parser;

use App\Service\Parser\Factory;
use Mockery as m;

/**
 * FactoryCollectionTest.
 */
class FactoryParserTest extends \PHPUnit_Framework_TestCase
{
    public function testRegisterParser()
    {
        $factory = new Factory();

        $this->assertSame($factory, $factory->registerParser('xml', 'XmlParserClass'));

        $this->assertAttributeCount(1, 'registered', $factory);
    }

    public function testMake()
    {
        m::mock('XmlParserClass');

        $factory = new Factory();
        $factory->registerParser('xml', 'XmlParserClass');

        $this->assertInstanceOf('XmlParserClass', $factory->make('xml'));
    }

    /**
     * @expectedException \App\Service\Exception\BindingResolutionException
     */
    public function testShouldThrowBindingExceptionWhenUnResolveableDependence()
    {
        $factory = new Factory();

        $factory->make('xml');
    }
}
