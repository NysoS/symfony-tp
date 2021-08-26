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
     * @Route("/admin", name="wish_list_admin")
     */
    public function list(WishRepository $repo): Response
    {

        $result = $repo->findBy([],array('dateCreated' => 'DESC'));

        return $this->render('wish/hometp.html.twig', [
            'wish_lst' => $result,
        ]);
    }

    /**
     * @Route("/admin/add", name="wish_add_admin")
     */
    public function addWish(Request $req, EntityManagerInterface $em): Response
    {
        
        $wish = new Wish();
        $form = $this->createForm(WishType::class,$wish);
        $form->handleRequest($req);
        
        if($form->isSubmitted()){
            
            $wish->setDateCreated(new DateTime('now'));
            $wish->setIsPublished(true);
            $em->persist($wish);
            $em->flush();

            return $this->redirectToRoute("wish_list_admin");

        }


        return $this->render('wish/formulaire_wish.html.twig', [
            'form_wish' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/quickAdd", name="wish_quick_add_admin")
     */
    public function quickAddWish(Request $req, EntityManagerInterface $em): Response
    {

        $title = $req->get('title');

        $wish = new Wish();
        $wish->setTitle($title);
        $wish->setDescription("");
        $wish->setAuthor("");
        $wish->setIsPublished(true);
        $wish->setDateCreated(new DateTime('now'));

        $em->persist($wish);
        $em->flush();

        return $this->redirectToRoute('wish_list_admin');
        
        
    }

    /**
     * @Route("/admin/modifie/{id}", name="wish_modif_admin")
     */
    public function updateWish(Wish $wish, Request $req, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(WishType::class,$wish);
        $form->handleRequest($req);
        
        if($form->isSubmitted()){
            
            $wish->setDateCreated(new DateTime('now'));
            $em->flush();

            return $this->redirectToRoute("wish_list_admin");

        }


        return $this->render('wish/formulaire_wish.html.twig', [
            'form_wish' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="wish_delete_admin")
     */
    public function deleteWish(Wish $wish, EntityManagerInterface $em): Response
    {
     
            $em->remove($wish);
            $em->flush();

        return $this->redirectToRoute('wish_list_admin');
    }
}

