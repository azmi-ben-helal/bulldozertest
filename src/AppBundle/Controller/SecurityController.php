<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/Add")
     */
    public function AddAction()
    {
        return $this->render('user_home.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/homepage")
     */
    public function RedirectionAction()
    {
        $authchecker=$this->container->get('security.authorization_checker');
        if($authchecker->isGranted('ROLE_ADMIN')){
            return $this->render('@App/url.html.twig');

        }
        return $this->render('@FOSUser/Security/login.html.twig');
    }

}
