<?php

namespace App\Form\Search;

use App\Entity\Search\UserSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => 'Nom',
            'required' => false
        ])
        ->add('prenom', TextType::class, [
            'label' => 'Prénom',
            'required' => false
        ])
        ->add('roles', ChoiceType::class, [
            'choices'  => [
                'Administrateur' => "ROLE_ADMIN",
                'Employé' => "ROLE_EMPLOYE",
            ],
            'required' => false,
            "expanded" => false,
            "multiple" => false
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserSearch::class,
        ]);
    }
}
