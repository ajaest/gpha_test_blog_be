<?php

namespace BlogBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Rest as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Options;
use Symfony\Component\DependencyInjection\ContainerInterface as ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as NotFoundHttpException;

use BlogBundle\Repository\PostRepository as PostRepository;


/**
 * @Route(service="blog.controllers.post")
 */
class PostController extends FOSRestController
{

    /**
     * @var PostRepository $userRepository
     */
    private $postRepository;

    /**
     * @param PostRepository $postRepository
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container, PostRepository $postRepository)
    {
        $this->container = $container;
        $this->postRepository = $postRepository;
    }

    /**
     * @Get("/posts/")
     */
    public function all()
    {
        return $this->postRepository->findAll();
    }

    /**
     * @Get("/posts/texts/")
     */
    public function texts()
    {
        return $this->postRepository->getTextPostRepository()->findAll();
    }

    /**
     * @Get("/posts/images/")
     */
    public function images()
    {
        return $this->postRepository->getImagePostRepository()->findAll();
    }

    /**
     * @Get("/posts/quotations/")
     */
    public function quotations()
    {
        return $this->postRepository->getQuotationPostRepository()->findAll();
    }

    /**
     * @Get("/posts/texts/{id}", requirements={"id": "\d+"})
     */
    public function textDetail($id)
    {
        return $this->getOr404($this->postRepository->getTextPostRepository(), $id);
    }

    /**
     * @Get("/posts/images/{id}", requirements={"id": "\d+"})
     */
    public function imageDetail($id)
    {
        return $this->getOr404($this->postRepository->getImagePostRepository(), $id);
    }

    /**
     * @Get("/posts/quotations/{id}", requirements={"id": "\d+"})
     */
    public function quotationDetail($id)
    {
        return $this->getOr404($this->postRepository->getQuotationPostRepository(), $id);
    }

    /**
     * @Post("/posts/")
     */
    public function create(){

    }

    private function getOr404($repository, $id){
        $obj = $repository->find($id);

        if(is_null($obj)){
            throw new NotFoundHttpException('Post not found');
        }

        return $obj;
    }


}
