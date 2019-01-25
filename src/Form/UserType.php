<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('roles', CollectionType::class, [
                        'entry_type'   => ChoiceType::class,
                        'entry_options'  => [
                            'label' => false,
                            'choices' => [
                                'Admin' => 'ROLE_ADMIN',
                                'Super' => 'ROLE_SUPER_ADMIN',
                            ],
                        ],
              ])                   
            ->add('password')
            ->add('verified')
            ->add('firstname')
            ->add('lastname')
            ->add('description')
            ->add('phone')
            ->add('adress')
            ->add('website')
            ->add('imgpath')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
