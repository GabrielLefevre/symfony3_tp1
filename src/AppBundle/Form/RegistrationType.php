<?php
/**
 * Created by PhpStorm.
 * User: DEV2
 * Date: 14/03/2017
 * Time: 09:08
 */

namespace AppBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', EntityType::class, array('class'=>'AppBundle:TypeAnimaux', 'choice_label'=>'name', 'multiple'=>true, 'expanded' => true));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}