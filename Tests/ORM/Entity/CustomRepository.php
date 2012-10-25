<?php
namespace Publero\FrameworkBundle\Tests\ORM\Entity;

use Publero\FrameworkBundle\ORM\EntityRepository;

class CustomRepository extends EntityRepository
{
    /**
     * @return boolean
     */
    public function isCustomRepository()
    {
        return true;
    }
}
