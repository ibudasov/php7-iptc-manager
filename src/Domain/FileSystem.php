<?php

declare(strict_types=1);

namespace iBudasov\Iptc\Domain;

interface FileSystem
{
    public function isFile(string $pathToFile): bool;

    public function deleteFile(string $pathToFile): void;

    public function createFileWithBinaryContent(string $pathToFile, string $binaryContent): bool;
}
