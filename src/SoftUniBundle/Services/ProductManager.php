<?php


namespace SoftUniBundle\Services;


use Doctrine\ORM\EntityManager;
use SoftUniBundle\Entity\Product;

class ProductManager
{
    protected $em;
    protected $repository;
    protected $fileUploader;

    public function __construct(EntityManager $em, FileUploader $fileUploader)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('SoftUniBundle:Product');

        $this->fileUploader = $fileUploader;
    }

    public function getAll()
    {
        return $this->repository->findAll();
    }

    public function getAllOrderedByRang()
    {
        return $this->repository->findBy([], ['rank' => 'ASC']);
    }

    public function createProduct(Product $product)
    {
        $product -> setCreatedAt(new \DateTime());
        $product -> setUpdatedAt(new \DateTime());

        $file = $product -> getPicture();
        $fileName = $this->fileUploader->upload($file);

        $product->setPicture($fileName);

        $this->em->persist($product);
        $this->em->flush();
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($product);
//        $em->flush();
    }

    public function removeProduct($product)
    {
        $this->em->remove($product);
        $this->em->flush();
    }

    public function getEntityManager()
    {
        return $this->em;
    }

    public function findProductBy($criteria, $keyword)
    {
        $predicate = "";
        $numOfCriteria = count($criteria);
        for ($i = 0; $i <$numOfCriteria; $i++){

            $predicate .= "pr.$criteria[$i] LIKE :key";
            if ($numOfCriteria != ($i+1)) {
                $predicate .= " OR ";
            }
        }

//        dump($predicate);

        //'pr.'.$criteria.' LIKE :key'
        $query = $this->repository->createQueryBuilder('pr')
            ->where($predicate)
            ->setParameter('key', '%'.$keyword.'%')
            ->getQuery();

        $products = $query->getResult();
//
//        dump($query);
//        dump($products); die("happy");

        return $products;
    }

}