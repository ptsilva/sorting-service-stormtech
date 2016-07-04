<?php

namespace App\Service\Parser\Contracts;

interface ParserCollectionInterface
{
    /**
     * Provides functionality to decode the encoded content.
     * 
     * @param  mixed $rawContent
     * @return mixed
     */
    public function decode($rawContent);

    /**
     * Provider functionality to encode array.
     * 
     * @param  array  $rawContent
     * @return mixed
     */
    public function encode(array $rawContent);
}
