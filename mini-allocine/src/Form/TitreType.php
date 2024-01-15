<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Titre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TitreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('contenu')
            ->add('categories',EntityType::class,[
                'class'=>Category::class,
                'choice_label'=>"nom",
                'multiple'=>true
            ])
            ->add('realisateur',TextType::class,['label'=>'Réalisateur','attr'=>['class'=>'exemple']])
            ->add('anneeSortie',IntegerType::class,  ['label'=>"Année de sortie"])           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Titre::class,
        ]);
    }
}
