<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use App\Entity\Sortie;
use Faker\Provider\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;  // Bonne importation
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class,[
                'label' => 'Pseudo :',
                'attr' => ['readonly' => true,]
            ])
            ->add('nom', TextType::class,[
                'label' => 'Nom :',

            ])
            ->add('prenom', TextType::class,[
                'label' => 'Prenom :',
            ])
            ->add('telephone', TextType::class,[
                'label' => 'Telephone :',
            ])
            ->add('email', TextType::class,[
                'label' => 'Email :',

            ])
            ->add('password', PasswordType::class,[
                'label' => 'Mot de passe :',

            ])
//            ->add('actif')
//            ->add('roles')
//            ->add('sorties', EntityType::class, [
//                'class' => Sortie::class,
//                'choice_label' => 'id',
//                'multiple' => true,
//            ])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
