<?php

namespace App\Service\Parser;

use App\Service\Parser\Contracts\ParserCollectionInterface;

class JsonParser implements ParserCollectionInterface
{
    /**
     * Provides functionality to decode the encoded content.
     * 
     * @param  mixed $rawContent
     * @return mixed
     */
    public function decode($encodedContent)
    {
        return json_decode($encodedContent, true)['data'];
    }

    /**
     * Provider functionality to encode array.
     * 
     * @param  array  $rawContent
     * @return mixed
     */
    public function encode(array $decodedContent)
    {
        return json_encode(['data' => $decodedContent]);
    }
}
