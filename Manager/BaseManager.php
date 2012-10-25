<?php
namespace Publero\FrameworkBundle\Manager;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;

class BaseManager
{
    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @return Registry
     */
    public function getDoctrine()
    {
        return $this->doctrine;
    }

    /**
     * @param Registry $doctrine
     */
    public function setDoctrine(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->doctrine->getEntityManager();
    }

    /**
     * @param string $persistentObjectName
     * @param string $persistentManagerName
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository($persistentObjectName, $persistentManagerName = null)
    {
        return $this->doctrine->getRepository($persistentObjectName, $persistentManagerName);
    }
}
