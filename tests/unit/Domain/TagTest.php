<?php

declare(strict_types=1);

namespace iBudasov\Iptc\Tests\UnitDomain;

use iBudasov\Iptc\Domain\Tag;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    public function testThatTagCanBeCreated(): void
    {
        $tag = new Tag('080', ['some-value']);
        self::assertEquals('080', $tag->getCode());
        self::assertEquals(['some-value'], $tag->getValues());
    }

    public function testThatTagCanBeConverterToString(): void
    {
        $tag = new Tag('080', ['some-value']);
        self::assertEquals('some-value', $tag);
    }
}
