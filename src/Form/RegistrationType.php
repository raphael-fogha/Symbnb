<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends ApplicationType
{   

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfig("Prenom","Entrez votre prenom"))
            ->add('lastName', TextType::class, $this->getConfig('Nom',"Entrez votre nom de famille"))
            ->add('email', EmailType::class, $this->getConfig('Email',"Entrez votre adresse email"))
            ->add('picture',UrlType::class, $this->getConfig("Photo de profil","Entrez l'url de votre avatar",[
                'required' => false
            ]))
            ->add('hash', PasswordType::class, $this->getConfig("Mot de passe","Entrez un mot de passe"))
            ->add('passwordConfirm', PasswordType::class, $this->getConfig("Confirmation mot de passe","Veuillez confirmer votre mot de passe"))
            ->add('introduction', TextType::class, $this->getConfig("Presentation", "Presentez-vous en quelques mots"))
            ->add('description', TextareaType::class, $this->getConfig("Description", "Presentez-vous en détails"));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);

    }
}

