<?php

declare(strict_types=1);

namespace iBudasov\Iptc\Domain;

class Tag
{
    public const AUTHOR = '080';
    public const KEYWORDS = '025';
    public const DESCRIPTION = '120';

    /**
     * @var int
     */
    private $type;

    /**
     * @var string which will be converted to int later
     */
    private $code;

    /**
     * @var string
     */
    private $value;

    /**
     * @param int    $typeOfTag
     * @param string $codeOfTag
     * @param string $valueOfTag
     */
    public function __construct(int $typeOfTag = 2, string $codeOfTag, string $valueOfTag)
    {
        $this->type = $typeOfTag;
        $this->code = $codeOfTag;
        $this->value = $valueOfTag;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->getValue();
    }
}
