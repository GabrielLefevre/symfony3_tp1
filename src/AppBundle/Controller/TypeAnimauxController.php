<?php
/**
 * Created by PhpStorm.
 * User: DEV2
 * Date: 13/03/2017
 * Time: 08:53
 */

namespace AppBundle\Controller;

use AppBundle\Entity\TypeAnimaux;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpKernel\Tests\Bundle\NamedBundle;


class TypeAnimauxController extends Controller
{

    public function newTypeAction(Request $request)
    {
        $type = new TypeAnimaux();
        $form = $this->createForm('AppBundle\Form\TypeAnimauxType', $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush($type);

            return $this->redirectToRoute('animaux_index', array());
        }

        return $this->render('typeAnimaux/newType.html.twig', array(
            'type' => $type,
            'form' => $form->createView(),
        ));
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typees = $em->getRepository('AppBundle:TypeAnimaux')->findAll();

        return $this->render('typeAnimaux/index.html.twig', array(
            'typees' => $typees,
        ));
    }

}