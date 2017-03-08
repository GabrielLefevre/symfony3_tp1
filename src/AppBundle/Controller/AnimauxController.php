<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Animaux;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpKernel\Tests\Bundle\NamedBundle;

/**
 * Animaux controller.
 *
 */
class AnimauxController extends Controller
{
    /**
     * Lists all animaux entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $animauxes = $em->getRepository('AppBundle:Animaux')->findAll();

        return $this->render('animaux/index.html.twig', array(
            'animauxes' => $animauxes,
        ));
    }

    /**
     * Creates a new animaux entity.
     *
     */
    public function newAction(Request $request)
    {
        $animaux = new Animaux();
        $form = $this->createForm('AppBundle\Form\AnimauxType', $animaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($animaux);
            $em->flush($animaux);

            return $this->redirectToRoute('animaux_show', array('id' => $animaux->getId()));
        }

        return $this->render('animaux/new.html.twig', array(
            'animaux' => $animaux,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a animaux entity.
     *
     */
    public function showAction(Animaux $animaux)
    {
        $deleteForm = $this->createDeleteForm($animaux);

        return $this->render('animaux/show.html.twig', array(
            'animaux' => $animaux,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing animaux entity.
     *
     */
    public function editAction(Request $request, Animaux $animaux)
    {
        $deleteForm = $this->createDeleteForm($animaux);
        $editForm = $this->createForm('AppBundle\Form\AnimauxType', $animaux);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('animaux_edit', array('id' => $animaux->getId()));
        }

        return $this->render('animaux/edit.html.twig', array(
            'animaux' => $animaux,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a animaux entity.
     *
     */
    public function deleteAction(Request $request, Animaux $animaux)
    {
        $form = $this->createDeleteForm($animaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($animaux);
            $em->flush($animaux);
        }

        return $this->redirectToRoute('animaux_index');
    }

    /**
     * Creates a form to delete a animaux entity.
     *
     * @param Animaux $animaux The animaux entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Animaux $animaux)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('animaux_delete', array('id' => $animaux->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Finds and displays a animaux entity.
     *
     */
    public function accouplementAction(Request $request)
    {
        $post = false;
        $em = $this->getDoctrine()->getManager();
        $animaux = $em->getRepository('AppBundle:Animaux')->findAll();

        $accouplementForm = $this->createAccouplementForm($animaux);


        if($request->getMethod() == "POST") {
            $post = true;
            $r="";
            $accouplementForm->handleRequest($request);
            if ($accouplementForm->isSubmitted() && $accouplementForm->isValid()) {
                //var_dump($accouplementForm->getData());
                $data=($accouplementForm->getData());
                $a1=$data["Animal1"];
                $a2=$data["Animal2"];
                 if($a1->getName() == $a2->getName()) {
                    echo ($a1->getName()." ne peut pas se reproduire sans son partenaire.");
                    // all
                }
                else if($a1->getAge()<3 || $a2->getAge()<3 ) {
                    echo("L'un des animaux est trop jeune, ils doivent avoir au moins 3ans pour se reproduire. ".$a1->getName()." à ".$a1->getAge()."ans, ".$a2->getName()." à ".$a2->getAge()."ans");
                    // tata + toto
                }
                else if ($a1->getType() != $a2->getType()) {
                    echo("Les deux animaux ne sont pas du même type.".$a1->getName()." est un(e) ".$a1->getType().", ".$a2->getName()." est un(e) ".$a2->getType());
                    // tata + babar
                }
                else if ($a1->getSexeMasc() == $a2->getSexeMasc()) {
                    echo("Les deuxs animaux sont de même sexe.");
                    // tata+tutu
                }
                else {
                     // ajout d'un nouvel animal
                }

            }
        }


        return $this->render('animaux/accouplement.html.twig',  array(
            'animaux' => $animaux,
            'methods' => $post,
            'accouplement_form' => $accouplementForm->createView()));
    }

    private function createAccouplementForm($animaux)
    {
       return $this->createFormBuilder()
            ->setAction($this->generateUrl('animaux_accouplement', array()))
            ->setMethod('POST')
            ->getForm()
           ->add('Animal1', EntityType::class, array('choices'  => $animaux, 'class'=>'AppBundle:Animaux'))
           ->add('Animal2', EntityType::class, array('choices'  => $animaux, 'class'=>'AppBundle:Animaux'))
           ->add('Accoupler', SubmitType::class)
           ;
    }




}

