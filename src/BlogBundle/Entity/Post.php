<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections;

class PostTypes{
    const TEXT_POST_DISCRIMINATOR      = 'text'     ;
    const QUOTATION_POST_DISCRIMINATOR = 'quotation';
    const IMAGE_POST_DISCRIMINATOR     = 'image'    ;
    const POST_DISCRIMINATOR           = NULL       ; // Prevent base type from being used
}


/**
 * @ORM\Entity(repositoryClass="BlogBundle\Repository\PostRepository")
 * @ORM\Table(name="blog_posts")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     Post::TEXT_POST_DISCRIMINATOR      = "TextPost"     ,
 *     Post::QUOTATION_POST_DISCRIMINATOR = "QuotationPost",
 *     Post::IMAGE_POST_DISCRIMINATOR     = "ImagePost"    ,
 *     Post::POST_DISCRIMINATOR           = "Post"
 * })
 */
class Post extends PostTypes {

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
     * @ORM\JoinTable(name="blog_post_tags")
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