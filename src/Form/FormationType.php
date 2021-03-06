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
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Description of FormationType
 *
 * @author monicatevy
 */
class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('publishedAt', DateType::class, [
                'label' => 'Date de publication',
                'data' => new \DateTime(),
                'required' => true,
            ])
            ->add('title', TextType::class, [
               'label' => 'Titre',
               'attr' => ['maxlength' => 100],
               'required' => true,
            ])
            ->add('description', TextareaType::class, [
               'label' => 'Description',
               'attr' => ['rows' => 6],
               'required' => false,
            ])
            ->add('miniature', TextType::class, [
               'label' => 'Miniature URL',
               'attr' => ['maxlength' => 100],
               'required' => false,
            ])
            ->add('picture', TextType::class, [
               'label' => 'Image URL',
               'attr' => ['maxlength' => 100],
               'required' => false,
            ])
            ->add('videoId', TextType::class, [
               'label' => 'Video ID',
               'attr' => ['maxlength' => 11],
               'required' => false, 
            ])
            ->add('niveau', EntityType::class, [
                'label' => 'Niveau',
                'class' => Niveau::class,
                'choice_label' => 'level',
                'required' => true,
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
