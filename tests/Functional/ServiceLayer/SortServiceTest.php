<?php

namespace Tests\Functional\ServiceLayer;

use App\Http\ServiceLayer\SortService;
use Mockery as m;

/**
 * ServiceLayerTest.
 *
 * @group group
 */
class ServiceLayerTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $factoryStrategy = m::mock('App\Service\Strategy\Contracts\FactoryStrategyInterface');
        $collection = m::mock('App\Service\Collection\Contracts\CollectionInterface');
        $factoryParser = m::mock('App\Service\Parser\Contracts\FactoryParserInterface');
        $sorter = m::mock('App\Service\Sorter\Contracts\SorterInterface');
        $parserException = m::mock('App\Service\Exception\Contracts\FactoryParserExceptionInterface');

        $factoryParser->shouldReceive('make')->twice()->andReturn(
            m::mock('App\Service\Parser\Contracts\ParserCollectionInterface')->shouldReceive('decode')->andReturn([])->mock(),
            m::mock('App\Service\Parser\Contracts\ParserCollectionInterface')->shouldReceive('encode')->andReturn([])->mock());

        $collection->shouldReceive('setItems')->mock();

        $factoryStrategy->shouldReceive('fromDecodeQueryString')->andReturn(
            m::mock('App\Service\Strategy\Contracts\SortStrategyInterface')
        )->mock();

        $sorter->shouldReceive('setSortStrategy')->shouldReceive('sort')->andReturn([]);

        $service = new SortService($factoryStrategy, $factoryParser, $collection, $sorter, $parserException);

        $this->assertEmpty($service->execute('application/xml', 'application/json', [], []));
    }
}
