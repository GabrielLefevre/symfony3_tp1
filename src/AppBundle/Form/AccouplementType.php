<?php
/**
 * Created by PhpStorm.
 * User: DEV2
 * Date: 15/03/2017
 * Time: 14:21
 */

namespace AppBundle\Form;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AccouplementType extends AbstractType
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
            ->add('Animal1', EntityType::class, array('class'=>'AppBundle:Animaux', 'choices'=> $this->user->getAnimaux()))
            ->add('Animal2', EntityType::class, array('class'=>'AppBundle:Animaux', 'choices'=> $this->user->getAnimaux()))
            ->add('Submit', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
          //  'data_class' => 'AppBundle\Entity\Animaux'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_accouplement';
    }
}