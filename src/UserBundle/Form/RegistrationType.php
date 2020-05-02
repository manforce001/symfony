<?php


namespace UserBundle\Form;

use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\DependencyInjection\Compiler\ExtensionCompilerPass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
            ->add('prenom')
            ->add('roles',ChoiceType::class,
                array('choices'=> array(
                    'Condidat'=>'ROLE_CANDIDAT',
                    'Spectateur'=>'ROLE_SPECTATEUR',
                     'Sponsor'=>'ROLE_SPONSOR',
                    'Jury'=>'ROLE_JURY'),
                    'multiple'=>true,
                    'required' => true,  ));



    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}