<?php

namespace SponsoringBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SponsoringType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description')
            ->add('type')
            ->add('image', FileType::class, array('label'=> 'inserer une image'))
            ->add('candidat',EntityType::class,array(
                'class'=>'SponsoringBundle:Candidat',
                'choice_label'=>'nom',
                'multiple'=>false
            ))
            ->add('sponsor',EntityType::class,array(
                'class'=>'SponsoringBundle:Sponsor',
                'choice_label'=>'nom',
                'multiple'=>false
            ))
            ->add('save' ,SubmitType::class);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SponsoringBundle\Entity\Sponsoring'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sponsoringbundle_sponsoring';
    }


}
