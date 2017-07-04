<?php

namespace SoftUniBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('SoftUniBundle:Default:index.html.twig');
    }

    /**
     * @Route("/test")
     */
    public function testAction()
    {
//        $this->get("app.email_sender")->testSendEmail();
//        return $this->render('SoftUniBundle:Default:index.html.twig');

        $products = $this->get("app.product_manager")->getAll();

        return $this->render('SoftUniBundle:product:index.html.twig', array(
            'products' => $products,
        ));

    }
}
