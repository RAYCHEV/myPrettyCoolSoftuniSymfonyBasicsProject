<?php


namespace SoftUniBundle\Services;


use Doctrine\ORM\EntityManager;
use SoftUniBundle\Entity\ProductCategory;

class ProductCategoryManager
{
    protected $em;
    protected $repository;
    protected $fileUploader;

    public function __construct(EntityManager $em, FileUploader $fileUploader)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('SoftUniBundle:ProductCategory');

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

    public function createProduct(ProductCategory $productCategory)
    {
        $productCategory -> setCreatedAt(new \DateTime());
        $productCategory -> setUpdatedAt(new \DateTime());

        $file = $productCategory -> getPicture();
        $fileName = $this->fileUploader->upload($file);

        $productCategory->setPicture($fileName);

        $this->em->persist($productCategory);
        $this->em->flush();
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($product);
//        $em->flush();
    }

    public function removeProduct($productCategory)
    {
        $this->em->remove($productCategory);
        $this->em->flush();
    }

    public function getEntityManager()
    {
        return $this->em;
    }

    public function findProductBy($criteria)
    {
        //my code here...
    }
}