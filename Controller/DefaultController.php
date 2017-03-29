<?php

namespace Lch\ComponentsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LchComponentsBundle:Default:index.html.twig');
    }
}
