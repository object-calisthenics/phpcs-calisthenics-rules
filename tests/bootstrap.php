<?php declare(strict_types=1);

use PHP_CodeSniffer\Util\Tokens;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/squizlabs/php_codesniffer/autoload.php';

if (! defined(T_CLOSURE)) {
    new Tokens();
}
