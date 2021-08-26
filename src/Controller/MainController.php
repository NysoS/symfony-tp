<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function list(WishRepository $repo): Response
    {

        $result = $repo->findBy(array('isPublished' => true), array('dateCreated' => 'DESC'));

        return $this->render('main/home.html.twig', [
            'wish_lst' => $result
        ]);
    }

    /**
     * @Route("/details/{id}", name="details")
     */
    public function details(Wish $wish, WishRepository $repo): Response
    {

        $result = $repo->findBy(array('isPublished' => true), array('dateCreated' => 'DESC'));

        if ($wish->getIsPublished()) {
            return $this->render('main/home.html.twig', [
                'wish_lst' => $result,
                'wish_detail' => $wish->getId()
            ]);
        }

        return $this->redirectToRoute("list");
    }
}
