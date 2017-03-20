<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AnimauxType extends AbstractType
{
    private $user;
    function __construct(TokenStorage $token) {
        $this->user = $token->getToken()->getUser();
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('age')
            ->add('sexe', ChoiceType::class, array('choices' => array('Male' => 'Male', 'Femelle' => 'Femelle')))
            ->add('photo', FileType::class, array('label' => 'Photo', 'required'=> false));
        $user =  $this->user;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($user){
            $form = $event->getForm();
            $animal = $event->getData();
            $animal->setDateTime(new \DateTime("now"));
            if($animal->getUser() == null ) {
                $animal->setUser($user);
            }
            $form->add('Type', EntityType::class, array('class'=>'AppBundle:TypeAnimaux', 'choices'=> $user->getType()));
        });
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Animaux'
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