<?php

declare(strict_types=1);

namespace iBudasov\Iptc\Tests;

use iBudasov\Iptc\Domain\FileSystem;
use iBudasov\Iptc\Domain\Image;
use iBudasov\Iptc\Domain\Tag;
use iBudasov\Iptc\Manager;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class ManagerTest extends TestCase
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * @var FileSystem|MockInterface
     */
    private $fileSystemMock;

    /**
     * @var Image|MockInterface
     */
    private $imageMock;

    protected function setUp(): void
    {
        $this->fileSystemMock = \Mockery::mock(FileSystem::class);
        $this->imageMock = \Mockery::mock(Image::class);

        $this->manager = new Manager(
            $this->fileSystemMock,
            $this->imageMock
        );
    }

    public function testThatClassCanBeInstantiated(): void
    {
        self::assertInstanceOf(Manager::class, $this->manager);
    }

    public function testThatPathToFileCanBeSetWhenFileTypeIsCorrect(): void
    {
        $pathToFile = '/tmp/test.jpg';

        $this->fileSystemMock->shouldReceive('isFile')
            ->once()
            ->with($pathToFile)
            ->andReturnTrue();

        $this->imageMock->shouldReceive('getIptcTags')
            ->once()
            ->with($pathToFile)
            ->andReturn(\json_decode('{"2#001":["\u001b%G"],"2#000":["\u0000\u0004"],"2#055":["20180328"],"2#060":["124126"],"2#062":["20180328"],"2#063":["124126"],"2#080":["IGOR BUDASOV"],"2#025":["norway","scandinavia","spring","2018","nordic","outdoor","relax","beautiful","tourism","hiking","walking","Cl lofoten islands","louds","cold","frost","Clououdy","clouds","sky","mountain","nature","background","cloudy","hillside","distance","highland"],"2#120":["Spring in Norway: a large mountain in the background"]}', true));

        self::assertNull($this->manager->setPathToFile($pathToFile));
    }

    public function testThatExceptionIsThrownWhenFileExtensionIsNotSupported(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $pathToFile = '/tmp/test.wrong';

        $this->manager->setPathToFile($pathToFile);
    }

    public function testThatExceptionIsThrownWhenFileDoesNotExist(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $pathToFile = '/tmp/test.jpg';

        $this->fileSystemMock->shouldReceive('isFile')
            ->once()
            ->with($pathToFile)
            ->andReturnFalse();

        self::assertNull($this->manager->setPathToFile($pathToFile));
    }

    public function testThatAllTheExistingTagsCanBeParsedAndReturned(): void
    {
        $pathToFile = '/tmp/test.jpg';

        $this->fileSystemMock->shouldReceive('isFile')
            ->once()
            ->with($pathToFile)
            ->andReturnTrue();

        $this->imageMock->shouldReceive('getIptcTags')
            ->once()
            ->with($pathToFile)
            ->andReturn([
                new Tag(2, '025', '["norway","scandinavia","spring"]'),
            ]);

        $this->manager->setPathToFile($pathToFile);

        self::assertInternalType('array', $this->manager->getTags());
        self::assertInstanceOf(Tag::class, \current($this->manager->getTags()));
    }

    public function testThatKeywordTagsCanBeReturned(): void
    {
        $pathToFile = '/tmp/test.jpg';

        $this->fileSystemMock->shouldReceive('isFile')
            ->once()
            ->with($pathToFile)
            ->andReturnTrue();

        $this->imageMock->shouldReceive('getIptcTags')
            ->once()
            ->with($pathToFile)
            ->andReturn([
                new Tag(2, '025', '["norway","scandinavia","spring"]'),
            ]);

        $this->manager->setPathToFile($pathToFile);

        self::assertEquals(
            '["norway","scandinavia","spring"]',
            $this->manager->getTag(Tag::KEYWORDS)
        );
    }

    public function testThatDescriptionTagsCanBeReturned(): void
    {
        $pathToFile = '/tmp/test.jpg';

        $this->fileSystemMock->shouldReceive('isFile')
            ->once()
            ->with($pathToFile)
            ->andReturnTrue();

        $this->imageMock->shouldReceive('getIptcTags')
            ->once()
            ->with($pathToFile)
            ->andReturn([
                new Tag(2, '120', 'some description'),
            ]);

        $this->manager->setPathToFile($pathToFile);

        self::assertEquals(
            'some description',
            $this->manager->getTag(Tag::DESCRIPTION)
        );
    }

    public function testThatAuthorTagsCanBeReturned(): void
    {
        $pathToFile = '/tmp/test.jpg';

        $this->fileSystemMock->shouldReceive('isFile')
            ->once()
            ->with($pathToFile)
            ->andReturnTrue();

        $this->imageMock->shouldReceive('getIptcTags')
            ->once()
            ->with($pathToFile)
            ->andReturn([
                new Tag(2, '080', 'AUTHOR NAME'),
            ]);

        $this->manager->setPathToFile($pathToFile);

        self::assertEquals(
            'AUTHOR NAME',
            $this->manager->getTag(Tag::AUTHOR)
        );
    }

    public function testThatNullIsReturnedWhenThereIsNoSuchATag(): void
    {
        $pathToFile = '/tmp/test.jpg';

        $this->fileSystemMock->shouldReceive('isFile')
            ->once()
            ->with($pathToFile)
            ->andReturnTrue();

        $this->imageMock->shouldReceive('getIptcTags')
            ->once()
            ->with($pathToFile)
            ->andReturn([]);

        $this->manager->setPathToFile($pathToFile);

        self::assertNull(
            $this->manager->getTag(Tag::AUTHOR)
        );
    }

    public function testThatTagsAreEncodedAndWrittenToPicture(): void
    {
        $pathToFile = '/tmp/test.jpg';

        $this->imageMock->shouldReceive('writeIptcTags')
            ->once()
            ->with($pathToFile, 'ook')
            ->andReturnTrue();

        $this->fileSystemMock->shouldReceive('isFile')
            ->once()
            ->with($pathToFile)
            ->andReturnTrue();

        $this->imageMock->shouldReceive('getIptcTags')
            ->once()
            ->with($pathToFile)
            ->andReturn([
                new Tag(2, '080', 'AUTHOR NAME'),
            ]);

        $this->manager->setPathToFile($pathToFile);

        self::assertNull($this->manager->write());
    }
}
