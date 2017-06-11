<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 */
class QuotationPost extends Post{
    function getType(){
        return Post::QUOTATION_POST_DISCRIMINATOR;
    }
}