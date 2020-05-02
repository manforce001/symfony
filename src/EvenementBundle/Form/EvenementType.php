<?php

namespace EvenementBundle\Form;

 use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
 use Symfony\Component\Form\Extension\Core\Type\IntegerType;
 use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, [
             'required' => true
        ])
            ->add('description', CKEditorType::class, [
                'error_bubbling' => true,
                'required' => true
            ])
            ->add('localisation',TextType::class,  [
                'error_bubbling' => true,
            ])
            ->add('etablissement',TextType::class,  [
                'error_bubbling' => true,
            ])
            ->add('dateDebut', DateType::class, [
                'error_bubbling' => true,
                'data' => new \DateTime()
            ])
            ->add('dateFin', DateType::class, [
                'error_bubbling' => true,
                'data' => new \DateTime()

            ])
            ->add('categories', ChoiceType::class, [
                'choices' => [
                    'Musique' => 'musique',
                    'Peinture' => 'peinture',
                    'Dance' => 'dance',
                ]
            ])
            ->add('nombreMaxParticipants', IntegerType::class, [
                'error_bubbling' => true,
            ])
            ->add('nombreMinParticipants', IntegerType::class, [
                'error_bubbling' => true,
            ])
            ->add('prix', IntegerType::class, [
                'error_bubbling' => true,
            ])
            ->add('isPublic', ChoiceType::class, [
                'choices' => [
                    'Publiée' => true,
                    'Non Publiée' => false,
                ]
            ])
            ->add('isPayed', ChoiceType::class, [
                'choices' => [
                    'Payed' => true,
                    'Non Payed' => false,
                ]
            ])

            ->add('imageFile', FileType::class, [
                'label' => 'image',
                'mapped' => false,
                'required' => true,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EvenementBundle\Entity\Evenement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'evenementbundle_evenement';
    }


}
