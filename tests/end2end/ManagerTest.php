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

        $this->manager->setPathToFile(__DIR__.'unsupported-file.png');
    }

    public function testThatExceptionIsThrownWhenFileDoesNotExist(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('File not found');

        $this->manager->setPathToFile('/tmp/imaginary-file.jpg');
    }

    public function testThatFileCanBeSetIfExistsAndSupported(): void
    {
        self::assertNull($this->manager->setPathToFile(__DIR__.'/proper-file.jpg'));
    }

    public function testThatAllTheExistingTagsCanBeParsedAndReturned(): void
    {
        self::assertNull($this->manager->setPathToFile(__DIR__.'/proper-file.jpg'));
        self::assertInternalType('array', $this->manager->getTags());
        self::assertInstanceOf(Tag::class, \current($this->manager->getTags()));
    }

    public function testThatArrayIsReturnedWhenThereAreNoTags(): void
    {
        self::assertNull($this->manager->setPathToFile(__DIR__.'/no-tags.jpg'));
        self::assertInternalType('array', $this->manager->getTags());
        self::assertEmpty($this->manager->getTags());
    }

    public function testThatAuthorTagCanBeReturned(): void
    {
        self::assertNull($this->manager->setPathToFile(__DIR__.'/proper-file.jpg'));
        self::assertEquals('IGOR BUDASOV', $this->manager->getTag(Tag::AUTHOR));
    }

    public function testThatTagsCanBeWritten(): void
    {
        self::assertNull($this->manager->setPathToFile(__DIR__.'/proper-file.jpg'));
        self::assertEquals('IGOR BUDASOV', $this->manager->getTag(Tag::AUTHOR));
        $this->manager->write();
    }
}
