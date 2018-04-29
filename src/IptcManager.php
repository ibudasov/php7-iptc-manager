<?php

declare(strict_types=1);

namespace IgorBudasov\IptcManager;

class IptcManager
{
    private const SUPPORTED_FILE_TYPES = ['jpg', 'jpeg', 'pjpeg'];

    /**
     * @var string
     */
    private $pathToFile;

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

        $this->pathToFile = $pathToFile;
    }
}
