<?php

declare(strict_types=1);

namespace iBudasov\Iptc\Domain;

interface Image
{
    public function getIptcTags(string $pathToFile): array;
}
