<?php

declare (strict_types=1);
namespace Carbon\Doctrine;

use Odigos\Carbon\Carbon;
use DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\VarDateTimeType;
class DateTimeType extends VarDateTimeType implements \Carbon\Doctrine\CarbonDoctrineType
{
    /** @use CarbonTypeConverter<Carbon> */
    use \Carbon\Doctrine\CarbonTypeConverter;
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Carbon
    {
        return $this->doConvertToPHPValue($value);
    }
}
