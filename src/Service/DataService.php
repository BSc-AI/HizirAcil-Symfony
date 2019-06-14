<?php


namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use App\Entity\Sheet;
class DataService
{
    protected $em;
    protected $container;

    public function __construct(EntityManagerInterface $entityManager,ContainerInterface $container){
        $this->em=$entityManager;
        $this->container=$container;
    }

    public function ReturnData($request){
        $em=$this->em;
        $container=$this->container;
        $query=$em->createQuery('
                    SELECT 
                        t.id,
                        t.sokak,
                        t.ilce,
                        t.cinsiyet,
                        t.yas,
                        t.hastane,
                        t.cagriyapan,
                        t.cagriyolu,
                        t.cagrinedeni,
                        t.kmfark,
                        t.sonuc
                   FROM 
                        App\Entity\Sheet t
                    ');
        //$result=$query->execute();
        $pagenator=$container->get('knp_paginator');
        $results=$pagenator->paginate(
            $query,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',10)
        );
        return ($results);
    }
}