<?php

namespace SoftUniBundle\Services;

use Doctrine\ORM\EntityManager;
use SoftUniBundle\Entity\Product;

class EmailSender
{
    protected $mailer;
    protected $em;

    public function __construct(\Swift_Mailer $mailer, EntityManager $em)
    {
        $this->mailer = $mailer;
        $this->em = $em;
    }

    public function sendEmailNewProduct(Product $product)
    {
        $msg= $product->getSlug()
            ."<br>". $product->getTitle()
            ."<hr>price: ". $product->getPrice();

        $message = \Swift_Message::newInstance()
            ->setSubject('new product has been added [my cool shop]')
            ->setFrom('quite.smart.stuff@gmail.com')
            ->setTo('nikolay.g.raychev@gmail.com')
            ->setBody($msg);

        $this->mailer->send($message);
    }

    /**
     * test function
     */
    public function sendEmail()
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('test email')
            ->setFrom('quite.smart.stuff@gmail.com')
            ->setTo('nikolay.g.raychev@gmail.com')
            ->setBody('new product has been created');

             $this->mailer->send($message);
    }


}