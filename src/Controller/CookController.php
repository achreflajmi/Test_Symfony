<?php

use App\Entity\Kitchen;
use App\Entity\Cook;
use App\Form\CookType;
use App\Repository\CookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CookController extends AbstractController
{
    #[Route('/cook', name: 'app_cook')]
    public function index(): Response
    {
        return $this->render('cook/index.html.twig', [
            'controller_name' => 'CookController',
        ]);
    }
     //afficher la table Cook
     #[Route('/showDBCook', name: 'showDBCook')]
     public function showDBCook(CookRepository $CookRepository): Response
     {
         $cook = $CookRepository->findBy(['Published' => true]);
         return $this->render('cook/showDBCook.html.twig', [
             'cook' => $cook,
         ]);
     }
     #[Route('/addDBcook', name: 'addDBcook')]
     public function addDBcook(ManagerRegistry $ManagerRegistry, Request $Req): Response
     {
         $em = $ManagerRegistry->getManager();
         $cook = new Cook();
         $form = $this->createForm(CookType::class, $cook);
         $form->handleRequest($Req);
       
         if ($form->isSubmitted() and $form->isValid()) {
            
             $kitchen=$cook->getKitchen();
             if($kitchen instanceof Kitcehn) //verifier qu'il est un objet d'une classe specifique
             $kitchen->setStaffNbr($kitchen->getStaffNbr()+1);
             $em->persist($cook);
             $em->flush();
             return $this->redirectToRoute('showDBCook');
         }
         return $this->renderForm('cook/addformcook.html.twig', [
             'f' =>$form
         ]);
     }
     #[Route('/editDBcook/{ref}', name: 'editDBcook')]
     public function editDBcook($ref,CookRepository $CookRepository,ManagerRegistry $ManagerRegistry, Request $Req): Response
     {
         $em = $ManagerRegistry->getManager();
         $dataid = $CookRepository->find($ref);
         $form = $this->createForm(CookType::class, $dataid);
         $form->handleRequest($Req);
         if ($form->isSubmitted() and $form->isValid()) {
             $em->persist($dataid);
             $em->flush();
             return $this->redirectToRoute('showDBCook');
         }
         return $this->renderForm('cook/editformcook.html.twig', [
             'fr' =>$form
         ]);
     }
     #[Route('/RemoveDBcook/{ref}', name: 'RemoveDBcook')]
     public function RemoveDBcook($ref,CookRepository $CookRepository,ManagerRegistry $ManagerRegistry): Response
     {
         $em = $ManagerRegistry->getManager();
         $dataid = $CookRepository->find($ref);
         $form = $this->createForm(CookType::class, $dataid);
             $em->remove($dataid);
             $em->flush();
             return $this->redirectToRoute('showDBCook');

     }


      #[Route('/Detailscook/{ref}', name: 'Detailscook')]
      public function Detailscook($ref,CookRepository $CookRepository): Response
      {
          $cook = $CookRepository->find($ref);
         
          return $this->renderForm('cook/Detailscook.html.twig', [
            'cook' => $cook
        ]);

      }
}
