<?php

namespace SoftUniBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class SendMailController extends Controller
{
    /**
     * @Route("/send")
     *
     * test controller
     */
    public function indexAction()
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('hello email')
            ->setFrom('quite.smart.stuff@gmail.com')
            ->setTo('nikolay.g.raychev@gmail.com')
            ->setBody('test message');

        $this->get('mailer')->send($message);
        return $this->render('SoftUniBundle:Default:index.html.twig');
    }
}
