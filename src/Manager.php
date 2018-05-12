<?php

declare(strict_types=1);

namespace iBudasov\Iptc;

use iBudasov\Iptc\Domain\FileSystem;
use iBudasov\Iptc\Domain\Image;

class Manager
{
    public const TAG_AUTHOR = '2#080';
    public const TAG_KEYWORDS = '2#025';
    public const TAG_DESCRIPTION = '2#120';

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
     * @var Image
     */
    private $image;

    /**
     * @var array
     */
    private $iptcTags;

    /**
     * @param FileSystem $fileSystem
     * @param Image      $image
     */
    public function __construct(FileSystem $fileSystem, Image $image)
    {
        $this->fileSystem = $fileSystem;
        $this->image = $image;
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

        if (false === $this->fileSystem->isFile($pathToFile)) {
            throw new \InvalidArgumentException('File not found');
        }

        $this->pathToFile = $pathToFile;

        $this->iptcTags = $this->image->getIptcTags($pathToFile);
    }

    /**
     * @return array
     */
    public function getIptcTags(): array
    {
        return $this->iptcTags;
    }

    /**
     * @param string $tagId
     *
     * @return array
     */
    public function getTagValue(string $tagId): array
    {
        return $this->iptcTags[$tagId];
    }
}
