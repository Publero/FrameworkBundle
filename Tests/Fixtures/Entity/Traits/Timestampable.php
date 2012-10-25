<?php
namespace Publero\FrameworkBundle\Tests\Fixtures\Entity\Traits;

use Publero\FrameworkBundle\Entity\Traits\Timestampable as TimestampableTrait;
use Publero\FrameworkBundle\Entity\Traits\TimestampableInterface;

class Timestampable implements TimestampableInterface
{
    use TimestampableTrait;
}
