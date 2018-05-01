<?php

declare(strict_types=1);

namespace iBudasov\Iptc\Infrastructure;

use iBudasov\Iptc\Domain\Image;

class StandardPhpImage implements Image
{
    public function getIptcTags(string $pathToFile): array
    {
        \getimagesize($pathToFile, $imageInfo);

        if (isset($imageInfo['APP13']) && false !== \iptcparse($imageInfo['APP13'])) {
            return \iptcparse($imageInfo['APP13']);
        }

        return [];
    }
}
