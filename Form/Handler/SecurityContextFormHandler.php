<?php
namespace Publero\FrameworkBundle\Form\Handler;

use Symfony\Component\Security\Core\SecurityContextInterface;

abstract class SecurityContextFormHandler extends BaseFormHandler
{
    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @param SecurityContextInterface $securityContext
     */
    public function setSecurityContext(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }
}
