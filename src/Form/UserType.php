<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo')
            ->add('firstname')
            ->add('lastname')
            ->add('birthday')
            ->add('email')
            ->add('phone')
            /*->add('addresses', CollectionType::class, array(
                'entry_type' => AddressType::class,
                'entry_options' => ['street' => false],
                'entry_options' => ['zc' => false],
                'entry_options' => ['city' => false],
                'entry_options' => ['country' => false],
                'entry_options' => ['isDefault' => false],
                'allow_add' => true,
                'allow_delete' => true,
            ))*/
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
