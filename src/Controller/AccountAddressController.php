<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAddressController extends AbstractController
{
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

              dd($address);
        }

        return $this->render('account/address_add.html.twig', [
           'form' => $form->createView(),
        ]);
    }
}