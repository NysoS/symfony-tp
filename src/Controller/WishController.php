<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/", name="wish_list")
     */
    public function list(): Response
    {
        return $this->render('wish/index.html.twig', [
            'controller_name' => 'WishController',
        ]);
    }
}
