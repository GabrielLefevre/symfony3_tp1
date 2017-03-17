<?php

namespace AppBundle\Controller;
use AppBundle\GlobalEvents;
use AppBundle\Entity\Animaux;
use AppBundle\Entity\User;
use AppBundle\Event\AnimalEvent;
use AppBundle\EventListener\AnimalListener;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
            $animalEvent = $this->get('app.event.animal.add');
            $animalEvent -> setAnimal1($animaux);
            $animalEvent -> setAnimal2($animaux);
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher-> dispatch(GlobalEvents::animal_add, $animalEvent);
            $animaux = $animalEvent->getAnimal1();

            $file = $animaux->getPhoto();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('images_directory'),$fileName);
            $animaux->setPhoto($fileName);
            die($animaux->getName());
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
        //$gd = $this->getDoctrine();
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
        $reponse="";
        $form = $this->createForm('AppBundle\Form\AccouplementType');
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $data = ($form->getData());
                $a1 = $data["Animal1"];
                $a2 = $data["Animal2"];

                $animalEvent = $this->get('app.event.animal.add');
                $animalEvent->setAnimal1($a1);
                $animalEvent->setAnimal2($a2);
                $dispatcher = $this->get('event_dispatcher');
                $dispatcher->dispatch(GlobalEvents::animal_add, $animalEvent);
                $reponse = $animalEvent->getReponse();
                if ($animalEvent->isValidation()) {
                    $animaux = $animalEvent->getAnimal1();
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($animaux);
                    $em->flush($animaux);
                }

            }
        return $this->render('animaux/accouplement.html.twig',  array(
            'reponse' => $reponse,
            'accouplement_form' => $form->createView()));
        }

}