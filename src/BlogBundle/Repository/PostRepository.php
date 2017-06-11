<?php

namespace BlogBundle\Repository;

use Doctrine\ORM;

class PostRepository extends ORM\EntityRepository{

    /** @var $textPostRepository      ORM\EntityRepository */
    private $textPostRepository;
    /** @var $imagePostRepository     ORM\EntityRepository */
    private $imagePostRepository;
    /** @var $quotationPostRepository ORM\EntityRepository */
    private $quotationPostRepository;

    function setPostClasses(
        $textEntityClass,
        $quotationEntityClass,
        $imageEntityClass

    ){
        $this->textPostRepository      = $this->getEntityManager()->getRepository($textEntityClass     );
        $this->quotationPostRepository = $this->getEntityManager()->getRepository($quotationEntityClass);
        $this->imagePostRepository     = $this->getEntityManager()->getRepository($imageEntityClass    );
    }

    /**
     * @return ORM\EntityRepository
     */
    public function getTextPostRepository(): ORM\EntityRepository
    {
        return $this->textPostRepository;
    }

    /**
     * @return ORM\EntityRepository
     */
    public function getImagePostRepository(): ORM\EntityRepository
    {
        return $this->imagePostRepository;
    }

    /**
     * @return ORM\EntityRepository
     */
    public function getQuotationPostRepository(): ORM\EntityRepository
    {
        return $this->quotationPostRepository;
    }


}