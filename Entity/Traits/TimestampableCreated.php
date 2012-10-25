<?php
namespace Publero\FrameworkBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @author Tomáš Pecsérke <tomas.pecseke@publero.com>
 */
trait TimestampableCreated
{
    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     * @return \Publero\FrameworkBundle\Entity\Traits\TimestampableInterface
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;

        return $this;
    }
}

