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

        $recipentEmails = $this->getRecipentEmail();
        for ($i = 0; $i <count($recipentEmails); $i++){

            $message = \Swift_Message::newInstance()
                ->setSubject('new product has been added [my cool shop]')
                ->setFrom('quite.smart.stuff@gmail.com')
                ->setTo(array_shift($recipentEmails[$i]))
                ->setBody($msg);

            $this->mailer->send($message);
        }
    }

    private function getRecipentEmail()
    {
        $repository = $this->em->getRepository("SoftUniBundle:SpamList");
        $qb = $repository
            ->createQueryBuilder('r')
            ->select('r.email')
            ->getQuery();

        $recipentEmail = $qb->getResult();
        return $recipentEmail;
    }

    /**
     * TEST function
     */
    public function testSendEmail()
    {
        $r = $this->getRecipentEmail();
//
//            for ($i = 0; $i <count($r); $i++){
//                dump(array_shift($r[$i]));
//            }
//            die();
        $message = \Swift_Message::newInstance()
            ->setSubject('test email')
            ->setFrom('quite.smart.stuff@gmail.com')
            ->setTo('nikolay.g.raychev@gmail.com')
            ->setBody('new product has been created');

             $this->mailer->send($message);
    }


}