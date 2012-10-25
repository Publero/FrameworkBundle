<?php
namespace Publero\FrameworkBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PubleroFrameworkBundle extends Bundle
{
    public function getParent()
    {
        return 'FrameworkBundle';
    }
}
