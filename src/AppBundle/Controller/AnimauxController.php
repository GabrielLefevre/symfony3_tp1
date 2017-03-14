<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Animaux;
use AppBundle\Entity\User;
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
       // var_dump($animauxes[2]);
        for ($i=0;$i<count($animauxes);$i++) {
            $animauxes[$i]->setType($animauxes[$i]->getType()->getName());
            $animauxes[$i]->setUser($animauxes[$i]->getUser()->getUsername());
        }

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
        $currentuser = $this->currentUser();
        $currentuserlisttype = $currentuser->getType();
       // var_dump($currentuserlisttype);

        $form = $this->createForm('AppBundle\Form\AnimauxType', $animaux,['currentuser'=>$currentuser, 'listtype'=>$currentuserlisttype]);
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
        $gd = $this->getDoctrine();
        $t = $animaux->getType()->getName();
        return $this->render('animaux/show.html.twig', array(
            'animaux' => $animaux,
            'type' => $t,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing animaux entity.
     *
     */
    public function editAction(Request $request, Animaux $animaux)
    {

        $currentuser = $this->currentUser();

        $deleteForm = $this->createDeleteForm($animaux);
        $editForm = $this->createForm('AppBundle\Form\AnimauxType', $animaux,['currentuser'=>$currentuser]);
        $editForm->handleRequest($request);



        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('animaux_show', array('id' => $animaux->getId()));
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
        $r ="";
        $em = $this->getDoctrine()->getManager();
        $animaux = $em->getRepository('AppBundle:Animaux')->findAll();
        $accouplementForm = $this->createAccouplementForm($animaux);

        if($request->getMethod() == "POST") {
            $post = true;
            $accouplementForm->handleRequest($request);
            if ($accouplementForm->isSubmitted() && $accouplementForm->isValid()) {
                //var_dump($accouplementForm->getData());
                $data=($accouplementForm->getData());
                $a1=$data["Animal1"];
                $a2=$data["Animal2"];

                $srvAccouplement = $this->container->get('app.validateur.accouplement');
                $srvAccouplement->setParent1($a1);
                $srvAccouplement->setParent2($a2);
                $r = $srvAccouplement->verificationParents();
            }
        }
        return $this->render('animaux/accouplement.html.twig',  array(
            'animaux' => $animaux,
            'methods' => $post,
            'reponse' => $r,
            'accouplement_form' => $accouplementForm->createView()));
    } // accouplementAction

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

    private function currentUser() {
        $em = $this->getDoctrine()->getManager();
        $currentusername = $this->get('security.token_storage')->getToken()->getUserName();
        $currentuser = $em->getRepository('AppBundle:User')->findOneBy(array('username'=>$currentusername));

        return $currentuser;
    }


}

