<?php

namespace drymek\PheanstalkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('drymekPheanstalkBundle:Default:index.html.twig', array('name' => $name));
    }
}
