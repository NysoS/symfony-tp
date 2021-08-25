<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/", name="wish_list")
     */
    public function list(WishRepository $repo): Response
    {

        $result = $repo->findBy(array('isPublished' => true),array('dateCreated' => 'DESC'));

        return $this->render('wish/hometp.html.twig', [
            'wish_lst' => $result,
        ]);
    }

    /**
     * @Route("/add", name="wish_add")
     */
    public function addWish(Request $req, EntityManagerInterface $em): Response
    {
        
        $wish = new Wish();
        $wish->setDateCreated(new DateTime('now'));
        $form = $this->createForm(WishType::class,$wish);
        $form->handleRequest($req);
        
        if($form->isSubmitted()){
            $em->persist($wish);
            $em->flush();

            return $this->redirectToRoute("wish_list");

        }


        return $this->render('wish/formulaire_wish.html.twig', [
            'form_wish' => $form->createView()
        ]);
    }
}

