<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Url;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UrlController extends Controller
{
    /**
     * @Route("/generateUrl", name="generateUrl")
     */


    public function CreateAction(Request $request)
    {

        $url = new Url();
        $currentUser= $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->createFormBuilder($url)
            //->add('users', TextType::class)
            ->add('url', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Generate short url'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $url = $form->getData();
            $urlService = $this->get('app.url_service');
            $shortUrl = $urlService->generateUrl($url,$currentUser);
            if(!empty($shortUrl)) {
                $this->addFlash('url', $shortUrl);
                return $this->redirectToRoute('generateUrl');
            }
        }

        return $this->render('@App/url.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/generateUrl/{slug}")
     */
    public function urlAction($slug)

    {
        $urlService = $this->container->get('app.url_service');
        $shortUrl = $urlService->getUrl($slug);

        if(!empty($shortUrl)){
            return new RedirectResponse($shortUrl);
        }

        throw new NotFoundHttpException('Sorry that route does not exist');

    }
}
