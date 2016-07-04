<?php

namespace Tests\Unit\Service;

/**
 * 
 */
class Fixture
{
    public static function getBooks()
    {
        return [
            ['title' => 'Java How to Program','author' => 'Deitel & Deitel', 'editionYear' => '2007'],
            ['title' => 'Patterns of Enterprise Application Architecture', 'author' => 'Martin Fowler', 'editionYear' => '2002'],
            ['title' => 'Head First Design Patterns', 'author' => 'Elisabeth Freeman', 'editionYear' => '2004'],
            ['title' => 'Internet & World Wide Web: How to Program', 'author' => 'Deitel & Deitel', 'editionYear' => '2007'],
        ];
    }
}
