<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections;


class BasePostTypes{
    const TEXT_POST_DISCRIMINATOR      = 'text'     ;
    const QUOTATION_POST_DISCRIMINATOR = 'quotation';
    const IMAGE_POST_DISCRIMINATOR     = 'image'    ;
    const BASE_POST_DISCRIMINATOR      = 'post'     ;
}


/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\Table(name="posts")
 */
class Post extends BasePostTypes
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=100, nullable=FALSE)
     */
    private $title;


    /**
     * @ORM\Column(type="text", nullable=FALSE)
     */
    private $content;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="posts")
     * @ORM\JoinTable(name="post_tags")
     */
    private $tags;

    public function __construct() {
        $this->tags = new Collections\ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed integer
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return Collections\ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }


}

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\Table(name="posts")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     BasePostTypes::TEXT_POST_DISCRIMINATOR      = "TextPost"     ,
 *     BasePostTypes::QUOTATION_POST_DISCRIMINATOR = "QuotationPost",
 *     BasePostTypes::IMAGE_POST_DISCRIMINATOR     = "ImagePost"    ,
 *     BasePostTypes::BASE_POST_DISCRIMINATOR      = "BasePost"
 * })
 */
abstract class BasePost extends Post{

}