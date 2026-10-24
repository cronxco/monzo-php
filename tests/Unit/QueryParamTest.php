<?php

namespace Amelia\Test\Monzo\Unit;

use PHPUnit\Framework\TestCase;
use Amelia\Monzo\Util\QueryParams;

class QueryParamTest extends TestCase
{
    public function testSimpleCase()
    {
        $params = new QueryParams([
            'foo' => 'bar',
            'baz' => 'abc',
            'abc' => 123,
        ]);

        $result = $params->build();

        foreach ([
            'foo=bar',
            'baz=abc',
            'abc=123',
        ] as $expected) {
            $this->assertStringContainsString($expected, $result);
        }
    }

    public function testUrlEncode()
    {
        $params = new QueryParams([
            'foo' => 'bar',
            'utf8' => "\u{2713}", // unicode tick
            'abc' => 123,
        ]);

        $result = $params->build();

        foreach ([
            'foo=bar',
            'utf8=%E2%9C%93',
            'abc=123',
        ] as $expected) {
            $this->assertStringContainsString($expected, $result);
        }
    }

    public function testArrays()
    {
        $params = new QueryParams([
            'expand' => ['merchant', 'transactions'],
            'foobar' => ['bar'],
            'abc' => 123,
        ]);

        $result = $params->build();

        foreach ([
            'expand[]=merchant',
            'expand[]=transactions',
            'foobar[]=bar',
            'abc=123',
        ] as $expected) {
            $this->assertStringContainsString($expected, $result);
        }
    }
}
