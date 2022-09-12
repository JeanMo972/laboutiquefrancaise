<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
         //dd ($options); vardump de $options
        $user = $options['user'];
        $builder
            ->add('addresses' ,EntityType::class ,[//formulaire pour afficher les adresses.


                //differentes options
                'label' => false,
                'required' => true,
                'class' => Address::class,
                'choices' => $user->getAddresses(),
                'multiple' => false,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure votre formulaire ici
            'user'=> array()
        ]);
    }
}
