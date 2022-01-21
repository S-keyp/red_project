<?php

namespace App\Form;

use App\Entity\ProBundles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProBundlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titleService', TypeTextType::class, [
                'label' => 'Nom de la Prestation'
            ])->add('descriptionService', TypeTextType::class,[
                'label' => 'Description Prestation'
            ])->add('Professionnal', TypeTextType::class,[
                'label' => 'Nom du Professionnel'
            ])->add('image_service', FileType::class,[
                'label' => 'Télecharger une image',
                'required' =>false
            ])->add('servicePrice', NumberType::class,[
                'label' => 'Prix de la prestation'
            ])->add('serviceCategory', ChoiceType::class,[
                'label' => 'Choix Catégorie',
                'choices' => ['Graphiste' => 'Graphiste' , 'Développement Web' =>'Développement', 'Référencement' => 'Réferencement']
            ])->add('save', SubmitType::class,[
                'label' => 'Ajouter'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProBundles::class,
        ]);
    }
}
