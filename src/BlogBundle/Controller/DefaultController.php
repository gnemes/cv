<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     */
    public function indexAction(Request $request)
    {
        $this->saveVisit($request, "home");
        return $this->render('BlogBundle:Default:index.html.twig');
    }
    
    /**
     * @Route("/blog/post/{id}", name="blog_post")
     */
    public function postAction(Request $request, $id)
    {
        $this->saveVisit($request, $id);
        
        $viewName = $this->getPostViewById($id);
        
        if ($viewName == '') {
            return $this->redirect($this->generateUrl('blog'));
        }
        
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
    
    protected function saveVisit($request, $post)
    {
        $visit = new \BlogBundle\Entity\Visit();
        $visit->setIp($request->getClientIp());
        $visit->setPost($post);
        
        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($visit);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();        
    }
}
