<?php

namespace App\Controller;

use App\Entity\Kitchen;
use App\Form\KitchenType;
use App\Repository\KitchenRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class KitchenController extends AbstractController
{
    #[Route('/kitchen', name: 'app_kitchen')]
    public function index(): Response
    {
        return $this->render('kitchen/index.html.twig', [
            'controller_name' => 'KitchenController',
        ]);
    }
    #[Route('/showKitchen/{name}', name: 'showKitchen')]
    public function showKitchen($name): Response
    {
        return $this->render('kitchen/show.html.twig', [
            'name' => $name,
        ]);
    }
    #[Route('/list', name: 'list')]
    public function list(): Response
    {
        return $this->render('kitchen/list.html.twig', [
            'kitchens' => $this->kitchens,
        ]);
    }
    #[Route('/kitchenDetails/{id}', name: 'kitchenDetails')]
    public function kitchenDetails($id): Response
    {
        $kitchen = null;
        foreach ($this->kitchens as $kitchenD) {
            if ($kitchenD['id'] == $id) {
                $kitchen = $kitchenD;
            }
        }
        return $this->render('kitchen/showKitchen.html.twig', [
            'kitchen' => $kitchen,
        ]);
    }
    #[Route('/showDBkitchen', name: 'showDBkitchen')]
    public function showDBkitchen(KitchenRepository $KitchenRepository,ManagerRegistry $ManagerRegistry): Response
    {
        $em = $ManagerRegistry->getManager();
        $kitchen = $KitchenRepository->findall();
        foreach ($kitchen as $kitchend)
        if($kitchend->getStaffNbr()==0)
        {
        $em->remove($kitchend);
        $em->flush();
        }
        return $this->render('kitchen/showDBkitchen.html.twig', [
            'kitchen' => $kitchen,
        ]);
    }
    #[Route('/addDBkitchen', name: 'addDBkitchen')]
    public function addDBkitchen(ManagerRegistry $ManagerRegistry, Request $Req): Response
    {
        $em = $ManagerRegistry->getManager();
        $kitchen = new Kitchen();
        $form = $this->createForm(KitchenType::class, $kitchen);
        $form->handleRequest($Req);
        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($kitchen);
            $em->flush();
            return $this->redirectToRoute('showDBkitchen');
        }
        return $this->renderForm('kitchen/addformkitchen.html.twig', [
            'f' =>$form
        ]);
    }
    #[Route('/editDBkitchen/{id}', name: 'editDBkitchen')]
    public function editDBkitchen($id,KitchenRepository $KitchenRepository,ManagerRegistry $ManagerRegistry, Request $Req): Response
    {
        $em = $ManagerRegistry->getManager();
        $dataid = $KitchenRepository->find($id);
        $form = $this->createForm(KitchenType::class, $dataid);
        $form->handleRequest($Req);
        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($dataid);
            $em->flush();
            return $this->redirectToRoute('showDBkitchen');
        }
        return $this->renderForm('kitchen/editDBkitchen.html.twig', [
            'frm' =>$form
        ]);
    }
    #[Route('/REMOVEDBkitchen/{id}', name: 'REMOVEDBkitchen')]
    public function REMOVEDBkitchen($id,KitchenRepository $KitchenRepository,ManagerRegistry $ManagerRegistry): Response
    {
        $em = $ManagerRegistry->getManager();
        $dataid = $KitchenRepository->find($id);
        $em->remove($dataid);
        $em->flush();
     
        return $this->redirectToRoute('showDBkitchen');
    }
}
