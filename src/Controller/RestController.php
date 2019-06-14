<?php


namespace App\Controller;

use App\Entity\Sheet;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Movie controller.
 * @Route("/api", name="api_")
 */
class RestController  extends FOSRestController
{
    /**
     * Lists all Movies.
     * @Rest\Get("/ilceler/")
     *
     * @return Response
     */
    public function getMovieAction()
    {
        $em = $this->getDoctrine()->getManager();
        $sql = 'SELECT ilce,tani FROM sheet';
        $statement = $em->getConnection()->prepare($sql);
        $statement->execute();
        $sorgular=$statement->fetchAll();

        $response = new Response(json_encode($sorgular));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Lists all Movies.
     * @Rest\Get("/ilceler/{ilceId}")
     *
     * @return Response
     */
    public function getDetails($ilceId)
    {
        $em = $this->getDoctrine()->getManager();
        $sql = "SELECT ilce,tani FROM sheet where ilceId=:ilceId";
        $statement = $em->getConnection()->prepare($sql);
        $statement->bindValue("ilceId",$ilceId);
        $statement->execute();
        $sorgular=$statement->fetchAll();
        $response = new Response(json_encode($sorgular));
        $response->headers->set('Content-Type', 'application/json');
        return $response;


    }
}