<?php

declare(strict_types=1);

namespace iBudasov\Iptc\Tests;

use iBudasov\Iptc\Domain\FileSystem;
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

    protected function setUp(): void
    {
        $this->fileSystemMock = \Mockery::mock(FileSystem::class);

        $this->manager = new Manager(
            $this->fileSystemMock
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
}
