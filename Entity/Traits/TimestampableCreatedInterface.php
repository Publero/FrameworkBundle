<?php
namespace Publero\FrameworkBundle\Entity\Traits;

/**
 * @author Tomáš Pecsérke <tomas.pecseke@publero.com>
 */
interface TimestampableCreatedInterface
{
    /**
     * @return DateTime
     */
    public function getCreated();

    /**
     * @param \DateTime $created
     * @return \Publero\FrameworkBundle\Entity\Traits\TimestampableInterface
     */
    public function setCreated(\DateTime $created);
}
