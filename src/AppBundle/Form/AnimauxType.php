<?php

namespace AppBundle\Form;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AnimauxType extends AbstractType
{

    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $options['listtype']
        // $options['currentuser']
        //'disabled' => true
        $builder
            ->add('name')
            ->add('age')
            ->add('type', EntityType::class, array('class'=>'AppBundle:TypeAnimaux', 'choice_label'=>'name'))
            ->add('User', EntityType::class, array('class'=>'AppBundle:User', 'choice_label'=>'username'))
            ->add('sexe', ChoiceType::class, array('choices' => array('Male' => 'Male', 'Femelle' => 'Femelle')));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Animaux',
            'currentuser' => null,
            'listtype' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_animaux';
    }


}