<?php
namespace Publero\FrameworkBundle\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * @author Tomáš Pecsérke <tomas.pecserke@publero.com>
 */
abstract class EnumType extends StringType
{
    /**
     * @return string
     */
    protected abstract function getEnumName();

    /**
     * @return string[]
     */
    protected abstract function getValues();

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value !== null && !in_array($value, $this->getValues())) {
            throw new \InvalidArgumentException("Invalid '" . $this->getName() . "' value.");
        }

        return $value;
    }

    public function getName()
    {
        return $this->getEnumName();
    }
}
