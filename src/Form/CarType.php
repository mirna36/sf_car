<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Group;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('year')
            ->add('engine')
            ->add('description')
            ->add('brand', EntityType::class,[
                'class' => Brand::class,
                'choice_label' => 'name'

            ])
            ->add('groupe', EntityType::class, [
                'class' => Group::class,
                'choice_label' => 'name'  
            ])
            ->add('Soumettre', SubmitType::class);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
