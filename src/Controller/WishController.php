<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/", name="wish_list")
     */
    public function list(WishRepository $repo): Response
    {

        $result = $repo->findAll(array('date_created' => 'ASC'));

        return $this->render('wish/hometp.html.twig', [
            'wish_lst' => $result,
        ]);
    }

    /**
     * @Route("/add", name="wish_add")
     */
    public function addWish(EntityManagerInterface $em): Response
    {
        
        $wish = new Wish();
        $wish->setTitle("vacances");
        $wish->setDescription("preparer les affaires avant de partir");
        $wish->setAuthor("Kristofer");
        $wish->setIsPublished(1);
        $dateImmutable = new DateTime("now");
        $wish->setDateCreated($dateImmutable);

        $em->persist($wish);
        $em->flush();

        return $this->redirectToRoute("wish_list");
    }
}

