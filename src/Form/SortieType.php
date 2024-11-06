<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Repository\CampusRepository;
use App\Repository\LieuRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => 'Nom de la sortie :'
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'label'=>'Date et heure de la sortie :',
                //'widget' => 'single_text',
            ])
            ->add('dateLimiteInscription',DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('nbInscriptionMax', TextType::class,[
                'label'=>'Nombre de places :'])
            ->add('duree', IntegerType::class, [
                'label'=>'Durée :'
                ])


            ->add('infosSortie', TextareaType::class,[
                'label'=>'Description et infos :'
            ])
//            ->add('participantInscrits', EntityType::class, [
//                'class' => Participant::class,
//                'choice_label' => 'id',
//                'multiple' => true,
//            ])
            ->add('campusOrganisateur', EntityType::class, [
                'label'=>'Campus :',
                'class' => Campus::class,
                'choice_label' => 'nom',
            ])
//            ->add('participantOrganisateur', EntityType::class, [
//                'class' => Participant::class,
//                'choice_label' => 'id',
//            ])
//            ->add('nom', EntityType::class,[
//                'class' => Ville::class,
//                'label'=>'Ville :',
//                'choice_label'=>'nom',])

            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'label'=>'Lieu :',
                'choice_label' => 'nom',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
