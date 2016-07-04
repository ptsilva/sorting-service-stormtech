<?php

namespace App\Providers;

use App\Service\Exception\FactoryParserException;
use App\Service\Exception\JsonParserException;
use App\Service\Strategy\EditionSortStrategy;
use App\Service\Comparator\FactoryComparator;
use App\Service\Exception\XmlparserException;
use App\Service\Comparator\NumberComparator;
use App\Service\Comparator\StringComparator;
use App\Service\Strategy\AuthorSortStrategy;
use App\Service\SortOrder\FactorySortOrder;
use App\Service\Strategy\TitleSortStrategy;
use App\Service\Strategy\FactoryStrategy;
use App\Service\SortOrder\DescendingSort;
use App\Service\SortOrder\AscendingSort;
use Illuminate\Support\ServiceProvider;
use App\Service\Parser\JsonParser;
use App\Service\Parser\XmlParser;
use App\Service\Parser\Factory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('factory.parser', function () {

            $factory = new Factory();
            $factory
                ->registerParser('application/json', JsonParser::class)
                ->registerParser('application/xml', XmlParser::class);

            return $factory;

        });

        $this->app->singleton('factory.strategy', function ($app) {

            $factory = new FactoryStrategy($app->make('factory.sort-order'), $app->make('factory.comparator'));
            $factory
                ->registerStrategy('title', TitleSortStrategy::class, 'string')
                ->registerStrategy('author', AuthorSortStrategy::class, 'string')
                ->registerStrategy('editionYear', EditionSortStrategy::class, 'number');

            return $factory;

        });

        $this->app->singleton('factory.sort-order', function () {

            $factory = new FactorySortOrder();
            $factory
                ->registerSortOrder('asc', AscendingSort::class)
                ->registerSortOrder('desc', DescendingSort::class);

            return $factory;
        });

        $this->app->singleton('factory.comparator', function () {

            $factory = new FactoryComparator();
            $factory
                ->registerComparator('number', NumberComparator::class)
                ->registerComparator('string', StringComparator::class);

            return $factory;

        });

        $this->app->singleton('factory.exception', function () {
            $factory = new FactoryParserException();

            $factory
                ->registerParser('application/xml', XmlparserException::class)
                ->registerParser('application/json', JsonParserException::class);

            return $factory;
        });

        $this->app->bind(\App\Service\Comparator\Contracts\FactoryComparatorInterface::class, 'factory.comparator');
        $this->app->bind(\App\Service\SortOrder\Contracts\FactorySortOrderInterface::class, 'factory.sort-order');
        $this->app->bind(\App\Service\Strategy\Contracts\FactoryStrategyInterface::class, 'factory.strategy');
        $this->app->bind(\App\Service\Parser\Contracts\FactoryParserInterface::class, 'factory.parser');
        $this->app->bind(\App\Service\Collection\Contracts\CollectionInterface::class, \App\Service\Collection\Collection::class);
        $this->app->bind(\App\Service\Sorter\Contracts\SorterInterface::class, \App\Service\Sorter\Sorter::class);
        $this->app->bind(\App\Service\Exception\Contracts\FactoryParserExceptionInterface::class, 'factory.exception');
    }

    public function provides()
    {
        return [
            'factory.parser',
            'factory.strategy',
            'factory.sort-order',
            'factory.comparator',
        ];
    }
}
