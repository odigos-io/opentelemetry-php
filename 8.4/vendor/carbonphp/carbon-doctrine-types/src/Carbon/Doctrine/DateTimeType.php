<?php

declare (strict_types=1);
namespace Odigos\Carbon\Doctrine;

use Odigos\Carbon\Carbon;
use DateTime;
use Odigos\Doctrine\DBAL\Platforms\AbstractPlatform;
use Odigos\Doctrine\DBAL\Types\VarDateTimeType;
class DateTimeType extends VarDateTimeType implements CarbonDoctrineType
{
    /** @use CarbonTypeConverter<Carbon> */
    use CarbonTypeConverter;
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Carbon
    {
        return $this->doConvertToPHPValue($value);
    }
}
