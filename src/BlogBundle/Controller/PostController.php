<?php

namespace BlogBundle\Controller;

use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Rest as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Options;
use Symfony\Component\DependencyInjection\ContainerInterface as ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as NotFoundHttpException;

use BlogBundle\Repository\PostRepository as PostRepository;
use BlogBundle\Form as Types;
use BlogBundle\Entity\PostTypes as PostTypes;


/**
 * @Route(service="blog.controllers.post")
 */
class PostController extends FOSRestController
{

    /** @var $postRepository PostRepository */
    private $postRepository;
    /** @var $tagRepository EntityRepository  */
    private $tagRepository;
    /**
     * @var Types\TextPostType */
    private $textPostType;
    /* @var Types\ImagePostType */
    private $imagePostType;

    private $PostTextClassName, $PostQuotationClassName, $PostImageClassName;

    /**
     * @param PostRepository $postRepository
     * @param ContainerInterface $container
     */
    public function __construct(
        ContainerInterface $container,
        PostRepository $postRepository,
        EntityRepository $tagRepository,
        Types\TextPostType $textPostType,
        Types\ImagePostType $imagePostType,
        $PostTextClassName,
        $PostQuotationClassName,
        $PostImageClassName
    )
    {
        $this->container = $container;

        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;

        $this->textPostType = $textPostType;
        $this->imagePostType = $imagePostType;

        $this->PostTextClassName = $PostTextClassName;
        $this->PostQuotationClassName = $PostQuotationClassName;
        $this->PostImageClassName = $PostImageClassName;
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
    public function create(Request $request){

        $obj = json_decode($request->getContent(), true);

        if(is_null($obj) ||  array_values($obj)===$obj || !array_key_exists('type', $obj)){
            throw new BadRequestHttpException('wrong json format');
        }

        $dataObj = NULL;
        switch($obj['type']){
            case PostTypes::TEXT_POST_DISCRIMINATOR:
                $dataObj = new $this->PostTextClassName();
                break;
            case PostTypes::IMAGE_POST_DISCRIMINATOR:
                $dataObj = new $this->PostImageClassName();
                break;
            case PostTypes::QUOTATION_POST_DISCRIMINATOR:
                $dataObj = new $this->PostQuotationClassName();
                break;
            default:
                throw new BadRequestHttpException('wrong post type');
        }

        $postFormType = $obj['type'] == PostTypes::IMAGE_POST_DISCRIMINATOR
                      ? $this->imagePostType
                      : $this->textPostType
        ;

        $obj['tags'] = $this->processTags($obj['tags']);

        $formBuilder = $this->createFormBuilder($dataObj, array('csrf_protection' => false));
        $form = $postFormType->buildForm($formBuilder, array('csrf_protection' => false));
        $form->submit($obj);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($dataObj);
            $em->flush();

            return $dataObj;
        }

        return $form;
    }

    private function getOr404($repository, $id){
        $obj = $repository->find($id);

        if(is_null($obj)){
            throw new NotFoundHttpException('Post not found');
        }

        return $obj;
    }

    private function processTags($tags){
        $tagNames = array_map(
            function ($tag){
                return $tag['name'];
            },
            $tags
        );

        $foundTags = $this->tagRepository->findBy(array('name'=>$tagNames));
        $foundTagNames = array_map(
            function ($tag){
                return $tag->getName();
            },
            $foundTags
        );

        $missingTagNames = array_diff($tagNames, $foundTagNames);

        $tagClass = $this->tagRepository->getClassName();
        foreach($missingTagNames as $missingTagName){
            $newTag = new $tagClass();
            $newTag->setName($missingTagName);
            $this->getDoctrine()->getManager()->persist($newTag);
            $foundTags[] = $newTag;
        }
        $this->getDoctrine()->getManager()->flush();

        $foundTagIds = array_map(
            function ($tag){
                return $tag->getId();
            },
            $foundTags
        );

        return $foundTagIds;
    }
}
