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
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT c.post, COUNT(c) as qty
            FROM BlogBundle:Comment c
            GROUP BY c.post'
        );

        $allComments = $query->getResult();       

        $comments = array();
        if (count($allComments)) {
            foreach($allComments as $comment) {
                $comments[$comment["post"]] = $comment["qty"];
            }
        }
        
        $this->saveVisit($request, "home");
        return $this->render(
            'BlogBundle:Default:index.html.twig',
            array(
                "comments" => $comments
            )    
        );
    }
    
    /**
     * @Route("/blog/post/{id}", name="blog_post")
     */
    public function postAction(Request $request, $id)
    {
        $comments = $this->getDoctrine()
                         ->getRepository('BlogBundle:Comment')
                         ->findByPost($id);        
        
        $this->saveVisit($request, $id);
        
        $viewName = $this->getPostViewById($id);
        
        if ($viewName == '') {
            return $this->redirect($this->generateUrl('blog'));
        }
        
        return $this->render(
            $viewName, 
            array(
                'post' => $id,
                'comments' => $comments
            )
        );
    }
    
    /**
     * @Route("/blog/comment", name="blog_comment_new")
     */
    public function commentAction(Request $request)
    {
        $nickname = $request->get("nickname");
        $userComment = $request->get("comment");
        $post = $request->get("post");
        
        if (
            (strlen($nickname) <= 30) &&
            (strlen($userComment) <= 255) &&    
            !is_null($post)    
        ) {
            $comment = new \BlogBundle\Entity\Comment();
            $comment->setIp($request->getClientIp());
            $comment->setPost($post);
            $comment->setNickname($nickname);
            $comment->setComment($userComment);

            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($comment);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();          
        }
        
        return $this->redirect($this->generateUrl('blog_post', array('id' => $post)), 301);
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
