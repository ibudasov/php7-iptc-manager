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

            $typeOfTag = (int) \reset($exploded);
            $codeOfTag = \end($exploded);

            if (\is_array($valueOfTag)) {
                $valueOfTag = \json_encode($valueOfTag);
            }

            $results[] = new Tag($typeOfTag, $codeOfTag, $valueOfTag);
        }

        return $results;
    }

    /**
     * @param string $pathToFile
     * @param string $binaryStringToWrite
     *
     * @return string Binary string of file content
     */
    public function writeIptcTags(string $pathToFile, string $binaryStringToWrite): string
    {
        // TODO: Implement writeIptcTags() method.
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
