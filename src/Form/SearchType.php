<?php

namespace App\Form;

use App\Entity\Campus;
use App\Form\Models\Search;
use ContainerMOPG5qE\getParticipantControllerService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campusOrganisateur',EntityType::class,[
                'label' => 'Campus',
                'class' => Campus::class,
                'choice_label' => 'nom',
                'placeholder' => 'Campus',
                'required' => false,

            ])
            ->add('recherche', TextType::class, [
                'label' => 'Le nom de la sortie contient:',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Search'
                ]
            ])
            ->add('dateEntre',DateType::class, [
                'label' => 'Entre',
                'widget' => 'single_text',
                'required' => false,

            ])
            ->add('dateFin',DateType::class, [
                'label' => 'et',
                'widget' => 'single_text',
                'required' => false,

            ])
            ->add('sortieOrganisateur',CheckboxType::class,[
                'label' => 'Sorties dont je suis l\'organisateur/trice',
                'required' => false,

            ])
            ->add('sortieInscrit',CheckboxType::class,[
                'label' => 'Sorties auxquelles je suis inscrit/e',
                'required' => false,
            ])
            ->add('sortieNonInscrit',CheckboxType::class,[
                'label' => 'Sorties auxquelles je ne suis pas inscrit/e',
                'required' => false,
            ])
            ->add('sortiePassee',CheckboxType::class,[
                'label' => 'Sorties passées',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
        ]);
    }
}
