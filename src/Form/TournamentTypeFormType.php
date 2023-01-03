<?php

namespace App\Form;

use App\Entity\TournamentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TournamentTypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class)
            ->add('skills',TextType::class)
            ->add('process', SubmitType::class)
        ;

        $builder->get('skills')
            ->addModelTransformer(new CallbackTransformer(
                function ($skillsAsArray) {
                    // transform the array to a string
                    return implode(', ', $skillsAsArray);
                },
                function ($skillsAsString) {
                    // transform the string back to an array
                    return explode(', ', $skillsAsString);
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TournamentType::class,
        ]);
    }
}
