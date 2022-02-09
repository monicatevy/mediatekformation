<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\Niveau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use \Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('publishedAt', DateType::class, [
                'label' => 'Date de publication',
                'required' => true,
            ])
            ->add('title', null, [
               'label' => 'Titre',
               'required' => true
            ])
            ->add('description', TextareaType::class, [
               'label' => 'Description',
                'attr' => ['rows' => '6'],
            ])
            ->add('miniature', null, [
               'label' => 'Miniature URL',
            ])
            ->add('picture', null, [
               'label' => 'Image URL',
            ])
            ->add('videoId', null, [
               'label' => 'Video ID',
            ])
            ->add('niveau', EntityType::class, [
                'label' => 'Niveau',
                'class' => Niveau::class,
                'choice_label' => 'level',
                'required' => true
            ])  
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
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
