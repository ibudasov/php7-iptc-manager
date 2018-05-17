<?php

declare(strict_types=1);

namespace iBudasov\Iptc\Domain;

class Tag
{
    const OBJECT_NAME = '005';
    const EDIT_STATUS = '007';
    const PRIORITY = '010';
    const CATEGORY = '015';
    const SUPPLEMENTAL_CATEGORY = '020';
    const FIXTURE_IDENTIFIER = '022';
    const KEYWORDS = '025';
    const RELEASE_DATE = '030';
    const RELEASE_TIME = '035';
    const SPECIAL_INSTRUCTIONS = '040';
    const REFERENCE_SERVICE = '045';
    const REFERENCE_DATE = '047';
    const REFERENCE_NUMBER = '050';
    const CREATED_DATE = '055';
    const CREATED_TIME = '060';
    const ORIGINATING_PROGRAM = '065';
    const PROGRAM_VERSION = '070';
    const OBJECT_CYCLE = '075';
    const AUTHOR = '080';
    const CITY = '090';
    const PROVINCE_STATE = '095';
    const COUNTRY_CODE = '100';
    const COUNTRY = '101';
    const ORIGINAL_TRANSMISSION_REFERENCE = '103';
    const HEADLINE = '105';
    const CREDIT = '110';
    const SOURCE = '115';
    const COPYRIGHT_STRING = '116';
    const DESCRIPTION = '120';
    const LOCAL_CAPTION = '121';
    const CAPTION_WRITER = '122';

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
     * @param int      $typeOfTag
     * @param string   $codeOfTag
     * @param string[] $valuesOfTag
     */
    public function __construct(int $typeOfTag, string $codeOfTag, array $valuesOfTag)
    {
        $this->type = $typeOfTag;
        $this->code = $codeOfTag;
        $this->value = $valuesOfTag;
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
     * @return string[]
     */
    public function getValues(): array
    {
        return $this->value;
    }

    public function __toString()
    {
        return \implode(', ', $this->getValues());
    }
}
