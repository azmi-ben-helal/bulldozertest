<?php

namespace AppBundle\Service;

use AppBundle\Entity\Url;
use AppBundle\Entity\User;
use AppBundle\Utility\Shorten;
use Couchbase\UserSettings;
use Doctrine\ORM\EntityManager;

class UrlService
{
    private $em;

    public function __construct(EntityManager $entity_manager)
    {
        $this->em = $entity_manager;
    }

    public function generateUrl(Url $url, User $id)
    {
        $url->setUsers($id);
        if (empty($url)) return;
        $shortUrl = $this->em->getRepository('AppBundle:Url')
            ->findOneByUrl($url->getUrl());
        //If already exists, return previosuly generated url
        if (!empty($shortUrl)) {
            return $shortUrl->getShortened();
        } else {
            $totalUrls = $this->em->getRepository('AppBundle:Url')
                ->findAll($url->getUrl());

            if ($totalUrls > 20) {

                $totalUrlsByUser = $this->em->getRepository('AppBundle:Url')
                    ->findBy(array('users' => $id));
                if (count($totalUrlsByUser) < 5) {
                    $shortUrl = uniqid();//Shorten::hash(count($totalUrls));
                    $url->setShortened($shortUrl);
                    $this->em->persist($url);
                    //$this->em->persist($id);
                    $this->em->flush();

                    return $shortUrl;
                } else {
                    return  'vous avez depasser les 5 liens';

                }
            } else {
                //$em = $this->getDoctrine()->getManager();
                /* $query = $this->em->createQueryBuilder('Url')
                     ->addOrderBy('Url.id', 'DESC')
                     ->setMaxResults(1)
                     ->getQuery()
                     ->getOneOrNullResult();
             $this->em->remove($query);

             $this->em->flush();
                 var_dump($query);
                 die('here');
                 $query->execute();
                 /*$OldRow = $this->createQueryBuilder('Url')
                 ->addOrderBy('Url.id', 'ASC')
                     ->setMaxResults(1)
                     ->getQuery()
                     ->getOneOrNullResult();*/
                /*if(!is_null($OldRow))*/
                /*{

                    $em = $this->getDoctrine()->getManager();
                    $data = $em->getReference('Url', $OldRow);
                    $em->remove($data);

                    $em->flush();
                }*/
                //$totalUrlsByUser = $this->em->getRepository('AppBundle:Url')->findAll(array('id' => 'DESC'));*/
            }
        }
    }

    public function getUrl($slug)
    {
        if (empty($slug)) return;
        $shortUrl = $this->em->getRepository('AppBundle:Url')
            ->findOneByShortened($slug);
        if (!empty($shortUrl)) {
            return $shortUrl->getUrl();
        }

        return;
    }
}
