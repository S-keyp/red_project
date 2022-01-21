<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfessionalFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Username'
            ])->add('email', EmailType::class, [
                'label' => 'Email'
            ])->add('password', PasswordType::class, [
                'label' => 'Mot de passe'
            ])->add('firstname', TextType::class, [
                'label' => 'Nom'
            ])->add('lastname', TextType::class, [
                'label' => 'Prénom'
            ])->add('adress', TextType::class, [
                'label' => 'Adresse'
            ])->add('tel', TelType::class, [
                'label' => 'Téléphone'
            ])->add('siret', TextType::class, [
                'label' => 'Siret'
            ])->add('society_name', TextType::class, [
                'label' => 'Nom de l\'entreprise'
            ])->add('description', TextType::class, [
                'label' => 'Description'
            ])->add('country', TextType::class, [       /* Ajouter role user + pro automatiquement */
                'label' => 'Pays'
            ])->add('code_postal', IntegerType::class, [
                'label' => 'Code postal'
            ])->add('profile_picture', TextType::class, [
                'label' => 'Photo de profil'
            ])->add('prestation', ChoiceType::class, [
                'label' => 'Prestation',
                'choices' => [
                    'English' => 'en',
                    'Spanish' => 'es',
                    'Bork' => 'muppets',
                    'Pirate' => 'arr',
                ],
                'preferred_choices' => ['muppets', 'arr'],
            ])->add('save', SubmitType::class, [
                'label' => 'Enregistrer'
            ]);
    }

    public function CheckboxForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('seo', CheckboxType::class, [
                'label' => 'SEO',
                ])->add('sea', CheckboxType::class, [
                'label' => 'SEA',
                ])->add('ref', CheckboxType::class, [
                'label' => 'Referencement',
                ])->add('designlogo', CheckboxType::class, [
                'label' => 'Design_logo',
                ])->add('cms', CheckboxType::class, [
                'label' => 'CMS',
                ])->add('mailing', CheckboxType::class, [
                'label' => 'Mailing',
                ])->add('devweb', CheckboxType::class, [
                'label' => 'Developpement_web',
                ])->add('devapp', CheckboxType::class, [
                'label' => 'Developpement_application',
                ])->add('valid', SubmitType::class, [
                'label' => 'Valider',
        ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
