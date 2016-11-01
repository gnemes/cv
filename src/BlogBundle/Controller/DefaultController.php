<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     */
    public function indexAction()
    {
        return $this->render('BlogBundle:Default:index.html.twig');
    }
    
    /**
     * @Route("/blog/post/{id}", name="blog_post")
     */
    public function postAction($id)
    {
        $viewName = $this->getPostViewById($id);
        return $this->render($viewName);
    }
    
    protected function getPostViewById($id)
    {
        switch ($id) {
            case 1:
                $view = 'BlogBundle:Default:posts/interfacepreference.html.twig';
                break;
            default:
                $view = '';
                break;
        }
        
        return $view;
    }
}
