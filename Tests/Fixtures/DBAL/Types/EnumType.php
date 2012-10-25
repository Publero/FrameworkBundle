<?php
namespace Publero\FrameworkBundle\Tests\Fixtures\DBAL\Types;

use Publero\FrameworkBundle\DBAL\Types\EnumType as BaseEnumType;

/**
 * @author Tomáš Pecsérke <tomas.pecserke@publero.com>
 */
class EnumType extends BaseEnumType
{
    /**
     * @var string[]
     */
    private $values;

    protected function getEnumName()
    {
        return 'enum';
    }

    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param string[] $values
     * @return EnumType
     */
    public function setValues(array $values)
    {
        $this->values = $values;

        return $this;
    }
}
