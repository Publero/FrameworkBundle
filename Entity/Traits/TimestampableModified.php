<?php
namespace Publero\FrameworkBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @author Tomáš Pecsérke <tomas.pecseke@publero.com>
 */
trait TimestampableModified
{
    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $modified;

    /**
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param \DateTime $modified
     * @return \Publero\FrameworkBundle\Entity\Traits\TimestampableInterface
     */
    public function setModified(\DateTime $modified)
    {
        $this->modified = $modified;

        return $this;
    }
}

