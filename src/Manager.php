<?php

declare(strict_types=1);

namespace iBudasov\Iptc;

use iBudasov\Iptc\Domain\FileSystem;

class Manager
{
    private const SUPPORTED_FILE_TYPES = ['jpg', 'jpeg', 'pjpeg'];

    /**
     * @var string
     */
    private $pathToFile;

    /**
     * @var FileSystem
     */
    private $fileSystem;

    /**
     * @param FileSystem $fileSystem
     */
    public function __construct(FileSystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    /**
     * @param string $pathToFile
     */
    public function setPathToFile(string $pathToFile): void
    {
        $fileExtension = \pathinfo($pathToFile, PATHINFO_EXTENSION);
        if (!\in_array($fileExtension, self::SUPPORTED_FILE_TYPES)) {
            throw new \InvalidArgumentException(
                    'Supported file types are: '.\json_encode(self::SUPPORTED_FILE_TYPES)
            );
        }

        if(false === $this->fileSystem->isFile($pathToFile)) {
            throw new \InvalidArgumentException('File not found');
        }

        $this->pathToFile = $pathToFile;
    }
}
