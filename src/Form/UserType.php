<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email', EmailType::class, [
            'label' => 'Email'
        ])
        ->add('nom', TextType::class, [
            'label' => 'Nom',
            'required' => true
        ])
        ->add('prenom', TextType::class, [
            'label' => 'Prénom',
            'required' => true
        ])
        ->add('roles', ChoiceType::class, [
            'choices'  => [
                'Administrateur' => "ROLE_ADMIN",
                'Employé' => "ROLE_EMPLOYE",
            ],
            "expanded" => false,
            "multiple" => false,
            'empty_data' => []
        ])
        ->add('password_clear', PasswordType::class, [
            "label" => "Mot de passe",
            "required" => false,
            "empty_data" => "",
            'help' => "Laissez ce champ vide si vous ne changez pas de mot de passe, ou bien saisissez le nouveau mot de passe."
        ]);
        

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
