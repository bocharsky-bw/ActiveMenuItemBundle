<?php

namespace BW\ActiveMenuItemBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DemoController extends Controller
{
    public function indexAction()
    {
        return $this->render('BWActiveMenuItemBundle:Demo:index.html.twig');
    }
}
