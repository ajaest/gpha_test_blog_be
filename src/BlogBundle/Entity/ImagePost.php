<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class ImagePost extends Post{
    function getType(){
        return Post::IMAGE_POST_DISCRIMINATOR;
    }

    /**
     * @ORM\PrePersist
     */
    public function convertFileToContent(){
        if(!is_string($this->getContent())){
            $this->setContent(
                'data:' . $this->getContent()->getMimeType() . ';base64,' .
                base64_encode(file_get_contents($this->getContent()))
            );
        }
    }
}