<?php

declare(strict_types=1);

namespace iBudasov\Iptc\Domain;

interface FileSystem
{
    public function isFile(string $pathToFile): bool;
}
