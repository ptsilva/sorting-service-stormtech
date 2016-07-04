<?php

namespace App\Service\Exception;

use App\Service\Exception\Contracts\ParserExceptionInterface;
use App\Service\Exception\Contracts\ParseableExceptionInterface;

class XmlparserException implements ParserExceptionInterface
{
    /**
     * Parses the exception.
     * 
     * @param  ParseableExceptionInterface $exception
     * @return mixed
     */
    public function parse(ParseableExceptionInterface $exception)
    {
        $xml = new \SimpleXMLElement('<error/>');

        $xml->addChild('exception', get_class($exception));
        $xml->addChild('messsage', $exception->getMessage());

        return $xml->asXML();
    }
}
