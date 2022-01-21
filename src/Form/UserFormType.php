<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Username'
            ])->add('password', PasswordType::class, [
                'label' => 'password'
            ])->add('firstname', TextType::class, [
                'label' => 'Prénom'
            ])->add('lastname', TextType::class, [
                'label' => 'Nom'
            ])->add('adress', TextType::class, [
                'label' => 'Adresse'
            ])->add('tel', TelType::class, [
                'label' => 'Téléphone'
            ])->add('profile_picture', TextType::class, [
                'label' => 'Photo de profil'
            ])->add('email', EmailType::class, [
                'label' => 'Email'
            ])->add('siret', TextType::class, [
                'label' => 'Siret'
            ])->add('society_name', TextType::class, [
                'label' => 'Nom de l\'entreprise'
            ])->add('description', TextType::class, [
                'label' => 'Description'
            ])->add('country', TextType::class, [
                'label' => 'Pays'
            ])->add('code_postal', IntegerType::class, [
                'label' => 'Code postal'
            ])->add('prestation', IntegerType::class, [
                'label' => 'Prestation'
            ])->add('save', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
