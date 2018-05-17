<?php

declare(strict_types=1);

namespace iBudasov\Iptc\Infrastructure;

use iBudasov\Iptc\Domain\Image;
use iBudasov\Iptc\Domain\Tag;

class StandardPhpImage implements Image
{
    /** {@inheritdoc} */
    public function getIptcTags(string $pathToFile): array
    {
        \getimagesize($pathToFile, $imageInfo);

        if ($this->thereIsNoIptcTags($imageInfo)) {
            return [];
        }
        $foundTags = \iptcparse($imageInfo['APP13']);
        $results = [];
        foreach ($foundTags as $key => $valueOfTag) {
            $exploded = \explode('#', $key);
            $codeOfTag = \end($exploded);

            $results[] = new Tag($codeOfTag, $valueOfTag);
        }

        return $results;
    }

    /**
     * @param string $pathToFile
     * @param string $binaryStringToWrite
     *
     * @return string
     */
    public function writeIptcTags(string $pathToFile, string $binaryStringToWrite): string
    {
        //@see http://php.net/manual/pt_BR/function.iptcembed.php
        return (string) \iptcembed($binaryStringToWrite, $pathToFile, 0);
    }

    /**
     * @param array $imageInfo
     *
     * @return bool
     */
    private function thereIsNoIptcTags(array $imageInfo): bool
    {
        return !isset($imageInfo['APP13']) || false === \iptcparse($imageInfo['APP13']);
    }
}
