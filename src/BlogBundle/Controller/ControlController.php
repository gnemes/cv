<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ControlController extends Controller
{
    /**
     * @Route("/blog/control", name="blog_control")
     */
    public function indexAction(Request $request)
    {
        return $this->render(
            'BlogBundle:Control:visits.html.twig',
            array(
                "visitsQty" => $this->getVisitsCount(),
                "commentsQty" => $this->getCommentsCount()
            )    
        );
    }
    
    protected function getVisitsCount()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT COUNT(c) as qty
            FROM BlogBundle:Visit c'
        );

        $visits = $query->getResult();
        
        return $visits[0]['qty'];
    }
    
    protected function getCommentsCount()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT COUNT(c) as qty
            FROM BlogBundle:Comment c'
        );

        $comments = $query->getResult();
        
        return $comments[0]['qty'];        
    }
}
