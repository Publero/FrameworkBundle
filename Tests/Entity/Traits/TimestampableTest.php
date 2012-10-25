<?php
namespace Publero\FrameworkBundle\Test\Entity\Traits;

use Publero\FrameworkBundle\Tests\Fixtures\Entity\Traits\Timestampable;

/**
 * @author Tomáš Pecsérke <tomas.pecseke@publero.com>
 */
class TimestampableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Timestampable
     */
    private $timestampable;

    public function setUp()
    {
        $this->timestampable = new Timestampable();
    }

    public function testGetAndSetCreated()
    {
        $created = new \DateTime();
        $this->timestampable->setCreated($created);

        $this->assertSame($created, $this->timestampable->getCreated());
    }

    public function testGetAndSetModified()
    {
        $modified = new \DateTime();
        $this->timestampable->setModified($modified);

        $this->assertSame($modified, $this->timestampable->getModified());
    }
}
