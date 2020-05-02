<?php

namespace EvenementBundle\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class, [
                'error_bubbling' => true,
            ])
            ->add('contenu',ChoiceType::class,[
                'choices' =>
                [
                    'image' => 'image',
                    'video' => 'video'

                ]
            ])
            ->add('description',CKEditorType::class, [
                    'error_bubbling' => true,
                    ])

            ->add('categorie',ChoiceType::class,[
                'choices' =>
                    [
                        'musique' => 'musique',
                        'peinture' => 'peinture',
                        'dance' => 'dance'

                    ]
            ])
            ->add('fileUpload', FileType::class, [
                'label' => 'image',
                'mapped' => false,
                'required' => false,
                ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EvenementBundle\Entity\Publication'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'evenement_publication';
    }


}
