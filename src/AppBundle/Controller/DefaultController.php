<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

// Contact form
use AppBundle\Entity\Message;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="landing")
     */
    public function indexAction(Request $request)
    {
        $message = new Message();
        
        $form = $this->createFormBuilder($message)
            ->setAction($this->generateUrl('landing'))
            ->setMethod('POST')    
            ->add(
                'name', 
                TextType::class, 
                array(
                    'label' => false,
               )
            )
            ->add(
                'email', 
                EmailType::class,
                array(
                    'label' => false,
               )
            )
            ->add(
                'message', 
                TextareaType::class,
                array(
                    'label' => false,
               )        
            )
            ->add('save', SubmitType::class, array('label' => 'Submit Message'))
            ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // TODO :: Handle message submission
            // echo var_dump($message);
            $messageDelivered = true;
        } else {
            $messageDelivered = false;
        }
        
        // replace this example code with whatever you need
        return $this->render(
            'default/index.html.twig', 
            [
                'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
                'form' => $form->createView(),
                'messageDelivered' => $messageDelivered,
            ]
        );
    }
}