<?php

namespace Tests\Unit\Service\Exception;

use Mockery as m;
use App\Service\Exception\JsonParserException;

/**
 * JsonParserExceptionTest.
 *
 * @group group
 */
class JsonParserExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $expectedMessage = 'message exception';

        $exception = m::mock('App\Service\Exception\Contracts\ParseableExceptionInterface')
        ->shouldReceive('getMessage')->andReturn($expectedMessage)->mock();

        $parser = new JsonParserException();

        $this->assertJsonStringEqualsJsonString(json_encode(['exception' => get_class($exception), 'message' => $expectedMessage]),
            $parser->parse($exception));
    }
}
