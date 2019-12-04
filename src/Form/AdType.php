<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfig("Titre","Titre de votre annonce"))
            ->add('slug', TextType::class, $this->getConfig("Chaine URL","Adresse web (automatique)",[
                'required' => false
            ]))
            ->add('introduction', TextType::class, $this->getConfig("Présentation","Décrivez succintement votre annonce"))
            ->add('content',TextareaType::class,$this->getConfig("Description", "Donnez envie aux visiteurs de venir chez vous !"))
            ->add('coverImage',UrlType::class,$this->getConfig("URL de l'image princiaple", "Donnez l'adresse d'une photo de votre bien"))
            ->add('rooms',IntegerType::class,['label' => 'Chambre(s)', 'attr' => ['min' => 0]])
            ->add('price',MoneyType::class, $this->getConfig("Prix ",'Indiquez le prix désiré pour une nuit'))
            ->add('images', CollectionType::class,
            [
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true
            ] )
            
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
