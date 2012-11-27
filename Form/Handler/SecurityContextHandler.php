<?php
namespace Publero\FrameworkBundle\Form\Handler;

use Symfony\Component\Security\Core\SecurityContext;

class SecurityContextHandler extends BaseHandler
{
    /**
     * @var SecurityContext
     */
    protected $securityContext;

    /**
     * @param SecurityContext $securityContext
     */
    public function setSecurityContext(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @return SecurityContext
     */
    public function getSecurityContext()
    {
        return $this->securityContext;
    }
}
