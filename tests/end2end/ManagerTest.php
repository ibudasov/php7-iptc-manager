<?php

declare(strict_types=1);

namespace iBudasov\Iptc\Tests\End2end;

use iBudasov\Iptc\Domain\Tag;
use iBudasov\Iptc\Manager;
use PHPUnit\Framework\TestCase;

class ManagerTest extends TestCase
{
    const PROPER_FILE = __DIR__.'/proper-file.jpg';
    const UNSUPPORTED_FILE = __DIR__.'unsupported-file.png';

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

        $this->manager->loadFile(self::UNSUPPORTED_FILE);
    }

    public function testThatExceptionIsThrownWhenFileDoesNotExist(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('File not found');

        $this->manager->loadFile('/tmp/imaginary-file.jpg');
    }

    public function testThatAllTheExistingTagsCanBeParsedAndReturned(): void
    {
        $this->manager->loadFile(self::PROPER_FILE);
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
        $this->manager->loadFile(self::PROPER_FILE);
        self::assertEquals('IGOR BUDASOV', $this->manager->getTag(Tag::AUTHOR));
    }

    /**
     * @throws \Exception
     */
    public function testThatTagsCanBeWritten(): void
    {
        $this->manager->loadFile(self::PROPER_FILE);
        self::assertEquals('IGOR BUDASOV', $this->manager->getTag(Tag::AUTHOR));
        $this->manager->write();
    }

    /**
     * @throws \Exception
     */
    public function testThatTagCanBeDeleted(): void
    {
        $this->manager->loadFile(self::PROPER_FILE);
        $this->manager->deleteTag(Tag::AUTHOR);
        self::assertNull($this->manager->getTag(Tag::AUTHOR));
        $this->manager->write();
    }

    /**
     * @throws \Exception
     */
    public function testThatTagCanBeAdded(): void
    {
        $this->manager->loadFile(self::PROPER_FILE);

        $tag = new Tag(Tag::AUTHOR, ['IGOR BUDASOV']);
        $this->manager->addTag($tag);

        $this->manager->write();

        self::assertEquals('IGOR BUDASOV', $this->manager->getTag(Tag::AUTHOR));
    }

    public function testThatExceptionWillBeThrownWhenAddingTagWhichAlreadyExists(): void
    {
        $pathToFile = self::PROPER_FILE;
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Trying to add tag with code \'080\' but it already exists in file '.$pathToFile);

        $this->manager->loadFile(self::PROPER_FILE);

        $tag = new Tag(Tag::AUTHOR, ['IGOR BUDASOV']);
        $this->manager->addTag($tag);
    }

    public function testThatExceptionIsThrownWhenTryingToDeleteTagWhichDoesNotExist(): void
    {
        $pathToFile = self::PROPER_FILE;
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Can not delete tag with code \'100\', because it does not exist in file '.$pathToFile);

        $this->manager->loadFile(self::PROPER_FILE);
        $this->manager->deleteTag(Tag::COUNTRY_CODE);
    }
}
