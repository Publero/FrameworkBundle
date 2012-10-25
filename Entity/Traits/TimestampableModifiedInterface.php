<?php
namespace Publero\FrameworkBundle\Entity\Traits;

/**
 * @author Tomáš Pecsérke <tomas.pecseke@publero.com>
 */
interface TimestampableModifiedInterface
{
    /**
     * @return DateTime
     */
    public function getModified();

    /**
     * @param \DateTime $modified
     * @return \Publero\FrameworkBundle\Entity\Traits\TimestampableInterface
     */
    public function setModified(\DateTime $modified);
}
