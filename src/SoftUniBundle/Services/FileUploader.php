<?php


namespace SoftUniBundle\Services;


use Doctrine\ORM\EntityManager;
use SoftUniBundle\Entity\Product;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    protected  $em;
    private $targetDir;

    public function __construct($targetDir, EntityManager $em)
    {
        $this->em = $em;
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file = null)
    {
        if ($file === null) {
            $fileName = 'default.png';
        } else {

            $fileName = md5(uniqid()).'-'.$file->getClientOriginalName();

            $file->move($this->targetDir, $fileName);
        }

        return $fileName;
    }

    /**
     * @param UploadedFile $file
     * @param Product $product
     */
    public function update(UploadedFile $file = null, $productID)
    {
        if ($file === null) {

            $fileName = 'default.png';
        }else {

            $repository = $this->em->getRepository('SoftUniBundle:Product');
            $query = $repository->createQueryBuilder('p')
                ->select('p.picture')
                ->where('p.id = ?1')
                ->setParameter(1, $productID)
                ->getQuery();

            $fileNameArr = $query->getResult();
            $oldFileName = array_shift($fileNameArr[0]);// array_shift($fileNameArr); //getting fileNameArr[0]
            $this->deleteFile($oldFileName);
//        if ($fileName == null) {
//            dump(array_shift($fileNameArr[0]), $file);
//            die; die;
//            echo 'NEOIJFOI';
////            $this->upload($file);
//        }
//        dump($fileName); die;
            $fileName = md5(uniqid()) . '-' . $file->getClientOriginalName();

            $file->move($this->targetDir, $fileName);
        }
        return $fileName;
    }

    public function deleteFile($fileName){

        if ($fileName == 'default.png') {
            return;
        }
        $fileSystem = new Filesystem();
        $fileSystem->remove($this->getTargetDir().$fileName);
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }
}