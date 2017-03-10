<?php
/**
 * Created by PhpStorm.
 * User: DEV2
 * Date: 10/03/2017
 * Time: 13:38
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Animaux;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpKernel\Tests\Bundle\NamedBundle;

class IndexController extends Controller
{

    public function indexAction()
    {
        return $this->render('default/index.html.twig', array());
    }
}

