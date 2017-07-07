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
        return $this->repository->findBy(['parent' => null]);
    }

    public function getAllOrderedByRang()
    {
        return $this->repository->findBy(['parent' => null], ['rank' => 'ASC']);
    }

    public function createProductCategory(ProductCategory $productCategory)
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

    public function removeProductCategory($productCategory)
    {
        $this->em->remove($productCategory);
        $this->em->flush();
    }

    public function getEntityManager()
    {
        return $this->em;
    }

    public function findProductCategoryBy($criteria, $keyword)
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

        $productCategories = $query->getResult();
//
//        dump($query);
//        dump($products); die("happy");

        return $productCategories;
    }
}
