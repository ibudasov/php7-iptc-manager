<?php

declare(strict_types=1);

namespace iBudasov\Iptc\Tests\UnitDomain;

use iBudasov\Iptc\Domain\Binary;
use iBudasov\Iptc\Domain\Tag;
use PHPUnit\Framework\TestCase;

class BinaryTest extends TestCase
{
    public function testThatTagCanBeEncodedToBinaryString(): void
    {
        $binary = new Binary();

        $tag = new Tag(2, Tag::AUTHOR, ['IGOR BUDASOV']);

        self::assertInternalType('string', $binary->createBinaryStringFromTag($tag));
    }
}
