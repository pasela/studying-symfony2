<?php

namespace Example\ExampleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template
     */
    public function indexAction()
    {
        return array('date' => date('Y-m-d H:i:s'));
    }
}
