<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 */
class TextPost extends Post{
    function getType(){
        return Post::TEXT_POST_DISCRIMINATOR;
    }
}