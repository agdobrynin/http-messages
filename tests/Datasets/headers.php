<?php

declare(strict_types=1);

\dataset('headers_success', [
    'set # 1' => [
        'headers' => ['content-type' => ['plain/text', 'undefined-type']],
        'expectHeaders' => ['content-type' => ['plain/text', 'undefined-type']],
    ],

    'set # 2' => [
        'headers' => ['content-type' => 'undefined-type'],
        'expectHeaders' => ['content-type' => ['undefined-type']],
    ],
]);

\dataset('headers_wrong', [
    'set # 1' => [
        'headers' => ['content type' => ['plain/text', 'undefined-type']],
        'exceptionMessage' => 'Header name must be RFC 7230 compatible',
    ],
    'set # 2' => [
        'headers' => ['❤' => ['plain/text', 'undefined-type']],
        'exceptionMessage' => 'Header name must be RFC 7230 compatible',
    ],
    'set # 3' => [
        'headers' => ['[ok]' => ['plain/text', 'undefined-type']],
        'exceptionMessage' => 'Header name must be RFC 7230 compatible',
    ],
    'set # 4' => [
        'headers' => ['файл' => ['plain/text', 'undefined-type']],
        'exceptionMessage' => 'Header name must be RFC 7230 compatible',
    ],
    'set # 5' => [
        'headers' => ['content-type' => (object) ['v' => 1]],
        'exceptionMessage' => 'Header value must be RFC 7230 compatible',
    ],
    'set # 6' => [
        'headers' => ['content-type' => [['v' => 1]]],
        'exceptionMessage' => 'Header value must be RFC 7230 compatible',
    ],
    'set # 7' => [
        'headers' => ['content-type' => \chr(8)],
        'exceptionMessage' => 'Header value must be RFC 7230 compatible',
    ],
]);