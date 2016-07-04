<?php

use App\Http\Controllers\SortController;
use Mockery as m;

/**
 * SortControllerTest.
 *
 * @group group
 */
class SortControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testSortMethod()
    {
        $request = m::mock('Illuminate\Http\Request')
        ->shouldReceive('header')
        ->shouldReceive('getContent')
        ->shouldReceive('get')->mock();
        $service = m::mock('App\Http\ServiceLayer\SortService')->shouldReceive('execute')->andReturn('sortedBooks')->mock();
        $controller = new SortController($request, $service);

        $this->assertInstanceOf('Illuminate\Http\Response', $controller->sort($request, $service));
    }
}
