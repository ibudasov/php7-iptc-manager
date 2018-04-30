<?php

declare(strict_types=1);

namespace iBudasov\Iptc\Tests\end2end;

use iBudasov\Iptc\Infrastructure\StandardPhpFileSystem;
use iBudasov\Iptc\Manager;
use PHPUnit\Framework\TestCase;

class ManagerTest extends TestCase
{
    public function testThatExceptionIsThrownWhenExtensionOfFileIsNotSupported(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Supported file types are: ["jpg","jpeg","pjpeg"]');

        $fileSystem = new StandardPhpFileSystem();
        $manager = new Manager($fileSystem);

        $manager->setPathToFile(__DIR__ . 'unsupported-file.png');
    }

    public function testThatExceptionIsThrownWhenFileDoesNotExist(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('File not found');

        $fileSystem = new StandardPhpFileSystem();
        $manager = new Manager($fileSystem);

        $manager->setPathToFile('/tmp/imaginary-file.jpg');
    }

    public function testThatFileCanBeSetIfExistsAndSupported(): void
    {
        $fileSystem = new StandardPhpFileSystem();
        $manager = new Manager($fileSystem);

        self::assertNull($manager->setPathToFile(__DIR__ . '/proper-file.jpg'));
    }
}
