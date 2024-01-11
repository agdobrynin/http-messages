<?php

declare(strict_types=1);

namespace Tests\Kaspi\HttpMessage\Unit\Uri;

use Kaspi\HttpMessage\Uri;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Uri::class)]
class PathTest extends TestCase
{
    public static function dataPathInConstructor(): \Generator
    {
        yield 'empty' => ['uri' => '', 'path' => ''];

        yield 'set #1' => ['uri' => 'https://user:pass@example.com:8080/path/123?q=abc#test', 'path' => '/path/123'];

        yield 'set #2' => ['uri' => '//example.org?q#h', 'path' => ''];

        yield 'set #3' => ['uri' => '//example/a:x', 'path' => '/a:x'];

        yield 'set #4' => ['uri' => '//example/../../etc/passwd', 'path' => '/../../etc/passwd'];
    }

    /**
     * @dataProvider dataPathInConstructor
     */
    public function testPathInConstructor(string $uri, string $path): void
    {
        $this->assertEquals($path, (new Uri($uri))->getPath());
    }

    public static function dataWithPath(): \Generator
    {
        yield 'empty path' => [
            'uri' => new Uri(''), 'path' => '', 'expect' => '',
        ];

        yield 'with unavailable symbols - "urlencode" use' => [
            'uri' => new Uri('http://www.com/index.html'),
            'path' => 'dir/просто.html',
            'expect' => 'dir/%D0%BF%D1%80%D0%BE%D1%81%D1%82%D0%BE.html',
        ];

        yield 'with available symbols only' => [
            'uri' => new Uri('http://www.com'),
            'path' => '/a/fz/~._-/0129/!x/$6/&rt/\'(abc)/*+/Y,/;=/%123:/@RE/%d0%bf',
            'expect' => '/a/fz/~._-/0129/!x/$6/&rt/\'(abc)/*+/Y,/;=/%123:/@RE/%d0%bf',
        ];
    }

    /**
     * @dataProvider dataWithPath
     */
    public function testWithPath(Uri $uri, string $path, string $expect): void
    {
        $new = $uri->withPath($path);

        $this->assertNotSame($new, $uri);
        $this->assertEquals($expect, $new->getPath());
    }
}