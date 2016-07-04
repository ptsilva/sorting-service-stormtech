<?php

namespace App\Http\ServiceLayer;

use App\Service\Exception\Contracts\FactoryParserExceptionInterface;
use App\Service\Exception\Contracts\ParseableExceptionInterface;
use App\Service\Strategy\Contracts\FactoryStrategyInterface;
use App\Service\Collection\Contracts\CollectionInterface;
use App\Service\Parser\Contracts\FactoryParserInterface;
use App\Service\Sorter\Contracts\SorterInterface;

/**
 * 
 */
class SortService
{
    protected $factoryParserException;
    protected $strategyFactory;
    protected $factoryParser;
    protected $collection;
    protected $sorter;

    public function __construct(
        FactoryStrategyInterface $factoryStrategy,
        FactoryParserInterface $factoryParser,
        CollectionInterface $collection,
        SorterInterface $sorter,
        FactoryParserExceptionInterface $parseException)
    {
        $this->strategyFactory = $factoryStrategy;
        $this->factoryParser = $factoryParser;
        $this->collection = $collection;
        $this->sorter = $sorter;
        $this->factoryParserException = $parseException;
    }

    public function execute($inputType, $outputType, $data, $strategies)
    {
        try {
            $inputParser = $this->factoryParser->make($inputType);

            $parserData = $inputParser->decode($data);

            $this->collection->setItems($parserData);

            $strategy = $this->strategyFactory->fromDecodeQueryString($strategies);

            $this->sorter->setSortStrategy($strategy);

            $sortedItems = $this->sorter->sort($this->collection);

            $outputParser = $this->factoryParser->make($outputType);
            
            return $outputParser->encode($sortedItems);
        } catch (ParseableExceptionInterface $e) {
            $parser = $this->factoryParserException->make($outputType);

            $e->setParser($parser);

            return $e->getParsedException();
        }
    }
}
