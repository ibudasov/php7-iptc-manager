<?php

declare(strict_types=1);

namespace IgorBudasov\IptcManager\Tests;

use IgorBudasov\IptcManager\IptcManager;
use PHPUnit\Framework\TestCase;

class IptcTest extends TestCase
{
    public function testThatClassCanBeInstantiated(): void
    {
        $manager = new IptcManager();

        self::assertInstanceOf(IptcManager::class, $manager);
    }

    public function testThatPathToFileCanBeSetWhenFileTypeIsCorrect(): void
    {
        $pathToFile = '/tmp/test.jpg';

        $manager = new IptcManager();

        self::assertNull($manager->setPathToFile($pathToFile));
    }

    public function testThatExceptionIsThrownWhenFileExtensionIsNotSupported(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $pathToFile = '/tmp/test.wrong';

        $manager = new IptcManager();

        $manager->setPathToFile($pathToFile);
    }
}
