<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Location;
use App\Entity\Voiture;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut',DateTimeType::class,[
                "widget"=>"single_text"
            ])
            ->add('dateRetour',DateTimeType::class,[
                "widget"=>"single_text"
            ])
            //->add('coefPrix')
//             ->add('client', EntityType::class, [
//                 'class' => Client::class,
// 'choice_label' => 'nom',
//             ])
            ->add('voiture', EntityType::class, [
                'class' => Voiture::class,
'choice_label' => 'modele',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
