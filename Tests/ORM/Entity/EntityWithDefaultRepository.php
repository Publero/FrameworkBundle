<?php
namespace Publero\FrameworkBundle\Tests\ORM\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Jiří Horký <jiri.horky@publero.com>
 *
 * @Entity
 * @Table(name="publero_frameworkbundle_orm_test_default")
 */
class EntityWithDefaultRepository
{
     /**
     * @Id
     * @Column(type="integer",name="id")
     * @GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @var string
     * @Column(name="title", type="string")
     */
    public $title;
}