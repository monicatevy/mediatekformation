<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\Niveau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('publishedAt', DateType::class, [
                'label' => 'Date de publication',
                'required' => true,
                'data' => new \DateTime(),
            ])
            ->add('title', TextType::class, [
               'label' => 'Titre',
               'required' => true,
               'attr' => ['maxlength' => 100],
            ])
            ->add('description', TextareaType::class, [
               'label' => 'Description',
               'required' => false,
               'attr' => ['rows' => 6],
            ])
            ->add('miniature', UrlType::class, [
               'label' => 'Miniature URL',
               'required' => false,
               'default_protocol' => null,
               'attr' => ['maxlength' => 100],
            ])
            ->add('picture', UrlType::class, [
               'label' => 'Image URL',
               'required' => false,
               'default_protocol' => null,
               'attr' => ['maxlength' => 100],
            ])
            ->add('videoId', TextType::class, [
               'label' => 'Video ID',
               'required' => false,
               'attr' => ['maxlength' => 11],
            ])
            ->add('niveau', EntityType::class, [
                'label' => 'Niveau',
                'required' => true,
                'class' => Niveau::class,
                'choice_label' => 'level',
            ])  
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
