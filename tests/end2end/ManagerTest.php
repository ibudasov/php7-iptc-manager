<?php

declare(strict_types=1);

namespace iBudasov\Iptc\Tests\End2end;

use iBudasov\Iptc\Domain\Tag;
use iBudasov\Iptc\Manager;
use PHPUnit\Framework\TestCase;

class ManagerTest extends TestCase
{
    /**
     * @var Manager
     */
    private $manager;

    protected function setUp(): void
    {
        $this->manager = Manager::create();
    }

    public function testThatExceptionIsThrownWhenExtensionOfFileIsNotSupported(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Supported file types are: ["jpg","jpeg","pjpeg"]');

        $this->manager->loadFile(__DIR__.'unsupported-file.png');
    }

    public function testThatExceptionIsThrownWhenFileDoesNotExist(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('File not found');

        $this->manager->loadFile('/tmp/imaginary-file.jpg');
    }

    public function testThatAllTheExistingTagsCanBeParsedAndReturned(): void
    {
        $this->manager->loadFile(__DIR__.'/proper-file.jpg');
        self::assertInternalType('array', $this->manager->getTags());
        self::assertInstanceOf(Tag::class, \current($this->manager->getTags()));
    }

    public function testThatArrayIsReturnedWhenThereAreNoTags(): void
    {
        $this->manager->loadFile(__DIR__.'/no-tags.jpg');
        self::assertInternalType('array', $this->manager->getTags());
        self::assertEmpty($this->manager->getTags());
    }

    public function testThatAuthorTagCanBeReturned(): void
    {
        $this->manager->loadFile(__DIR__.'/proper-file.jpg');
        self::assertEquals('IGOR BUDASOV', $this->manager->getTag(Tag::AUTHOR));
    }

    /**
     * @throws \Exception
     */
    public function testThatTagsCanBeWritten(): void
    {
        $this->manager->loadFile(__DIR__.'/proper-file.jpg');
        self::assertEquals('IGOR BUDASOV', $this->manager->getTag(Tag::AUTHOR));
        $this->manager->write();
    }
}
