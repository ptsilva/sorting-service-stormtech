<?php

namespace Tests\Unit\Service\Exception;

use App\Service\Exception\BindingResolutionException;
use Mockery as m;

/**
 * BindingResolutionExceptionTest.
 *
 * @group group
 */
class BindingResolutionExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testSetParser()
    {
        try {
            throw new BindingResolutionException('Error Processing Request', 1);
        } catch (BindingResolutionException $e) {
            $parser = m::mock('App\Service\Exception\Contracts\ParserExceptionInterface');

            $this->assertSame($e, $e->setParser($parser));
        }
    }

    public function testGetParsedException()
    {
        try {
            throw new BindingResolutionException('Error Processing Request', 1);
        } catch (BindingResolutionException $e) {
            $parser = m::mock('App\Service\Exception\Contracts\ParserExceptionInterface')
            ->shouldReceive('parse')->andReturn('parsedException')->mock();

            $this->assertEquals('parsedException', $e->setParser($parser)->getParsedException());
        }
    }
}
