<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAddressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){

        $this->entityManager = $entityManager;
    }

    #[Route('/compte/adresses', name: 'app_account_address')]
    public function index(): Response
    {
        // dd($this->getUser());

        return $this->render('account/address.html.twig', [

        ]);
    }

    #[Route('/compte/ajouter-une-adresse', name: 'app_account_address_add')]
    public function add(Request $request): Response
    {
        $address = new Address();

        //je passe en paramètres a ma fonction createForm() Le type du formulaire et l'objet
        $form = $this->createForm(AddressType::class, $address);

        //ecoute la requête
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) { 

            $address->setUser($this->getUser());
            //fige la data
            $this->entityManager->persist($address);
//execute la data
            $this->entityManager->flush();//execute la data

              //dd($address);
        return $this->redirectToRoute('app_account_address');
    }
    return $this->render('account/address_add.html.twig',[
        'form' => $form->createView(),
         ]);
    }
}