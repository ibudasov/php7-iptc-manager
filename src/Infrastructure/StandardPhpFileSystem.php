<?php

declare(strict_types=1);

namespace iBudasov\Iptc\Infrastructure;

use iBudasov\Iptc\Domain\FileSystem;

class StandardPhpFileSystem implements FileSystem
{
    public function isFile(string $pathToFile): bool
    {
        return \file_exists($pathToFile);
    }
}
