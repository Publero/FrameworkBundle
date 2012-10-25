<?php
namespace Publero\FrameworkBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @author Tomáš Pecsérke <tomas.pecseke@publero.com>
 */
trait Timestampable
{
    use TimestampableCreated;

    use TimestampableModified;
}
