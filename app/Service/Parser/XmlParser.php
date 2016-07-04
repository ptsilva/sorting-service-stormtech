<?php

namespace App\Service\Parser;

use App\Service\Parser\Contracts\ParserCollectionInterface;

class XmlParser implements ParserCollectionInterface
{
    /**
     * Provides functionality to decode the encoded content.
     * 
     * @param  mixed $rawContent
     * @return mixed
     */
    public function decode($xml)
    {
        $loadedXml = simplexml_load_string($xml);

        if (! $loadedXml) {
            return [];
        }

        return $this->parseXmlToArray($loadedXml);
    }

    /**
     * Provider functionality to encode array.
     * 
     * @param  array  $rawContent
     * @return mixed
     */
    public function encode(array $content)
    {
        $xml = new \SimpleXMLElement('<data/>');
        foreach ($content as $book) {
            $xmlBook = $xml->addChild('book');

            foreach ($book as $key => $value) {
                $xmlBook->addChild($key, htmlentities($value));
            }
        }

        return $xml->asXML();
    }

    /**
     * Iterate on xml tree and return array content.
     * 
     * @param  string $xml
     * @return array
     */
    protected function parseXmlToArray($xml)
    {
        $items = [];

        foreach ($xml->book as $book) {
            $items[] = (array) $book[0];
        }

        return $items;
    }
}
