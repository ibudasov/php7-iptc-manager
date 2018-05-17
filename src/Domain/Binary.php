<?php

declare(strict_types=1);

namespace iBudasov\Iptc\Domain;

class Binary
{
    /**
     * @param Tag $tag
     *
     * @return string
     */
    public function createBinaryStringFromTag(Tag $tag): string
    {
        //beginning of the binary string
        $beginningOfTheBinaryString = \chr(0x1c)
            .\chr($tag->getType())
            .\chr($tag->getCode());

        $binaryString = '';
        foreach ($tag->getValues() as $value) {
            $lengthOfValue = \strlen($value);
            $binaryString .= $beginningOfTheBinaryString
                .$this->getBitSize($lengthOfValue)
                .$value;
        }

        return $binaryString;
    }

    /**
     * @param int $lengthOfTheCharacter - size of the character
     *
     * @return string
     */
    private function getBitSize(int $lengthOfTheCharacter): string
    {
        return
            chr($lengthOfTheCharacter >> 8)
            .chr($lengthOfTheCharacter & 0xff);
    }
}
