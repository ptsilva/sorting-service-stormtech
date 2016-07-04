<?php

namespace Tests\Unit\Service\Comparator;

use App\Service\Comparator\FactoryComparator;
use Mockery as m;

/**
 * FactoryComparatorTest.
 *
 * @group group
 */
class FactoryComparatorTest extends \PHPUnit_Framework_TestCase
{
    public function testRegisterComparator()
    {
        $factory = new FactoryComparator();

        $this->assertSame($factory, $factory->registerComparator('type', 'TypeComparator'));

        $this->assertAttributeCount(1, 'registered', $factory);
    }

    public function testMake()
    {
        $factory = new FactoryComparator();

        m::mock('TypeComparator');

        $factory->registerComparator('type', 'TypeComparator');

        $this->assertInstanceOf('TypeComparator', $factory->make('type'));
    }

    /**
     * @expectedException \App\Service\Exception\BindingResolutionException
     */
    public function testShouldThrowBindingExceptionWhenUnResolveableDependence()
    {
        $factory = new FactoryComparator();

        $factory->make('type');
    }
}
