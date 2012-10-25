<?php
namespace Publero\FrameworkBundle\Tests\DBAL\Types;

use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Types\Type;
use Publero\FrameworkBundle\Tests\Fixtures\DBAL\Types\EnumType;

/**
 * @author Tomáš Pecsérke <tomas.pecserke@publero.com>
 */
class EnumTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EnumType
     */
    private $enumType;

    /**
     * @var MySqlPlatform
     */
    private $platform;

    public static function setUpBeforeClass()
    {
        Type::addType('enum', 'Publero\FrameworkBundle\Tests\Fixtures\DBAL\Types\EnumType');
    }

    protected function setUp()
    {
        $this->enumType = Type::getType('enum');
        $this->enumType->setValues(array('value_1', 'value_2'));
        $this->platform = new MySqlPlatform();
    }

    public function testConvertToDatabaseValue()
    {
        $this->assertNotNull($this->enumType->convertToDatabaseValue('value_1', $this->platform));
        $this->assertNotNull($this->enumType->convertToDatabaseValue('value_2', $this->platform));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConvertToDatabaseValueInvalid()
    {
        $this->assertNotNull($this->enumType->convertToDatabaseValue('value_3', $this->platform));
    }
}
