<?php

declare(strict_types=1);

namespace iBudasov\Iptc\Domain;

/**
 * This interface abstracts standard php functions to make it possible to unit test all the dependent code.
 */
interface Image
{
    /**
     * @param string $pathToFile
     *
     * @return Tag[]
     */
    public function getIptcTags(string $pathToFile): array;

    /**
     * @param string $pathToFile
     * @param string $binaryStringToWrite
     *
     * @return string Binary string of file content
     */
    public function writeIptcTags(string $pathToFile, string $binaryStringToWrite): string;
}
