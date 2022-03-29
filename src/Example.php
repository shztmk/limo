<?php declare(strict_types=1);

namespace Limo;

final class Example
{
    final public function __invoke(): string
    {
        return 'example';
    }
}