<?php

namespace AppBundle\Controller;
use AppBundle\GlobalEvents;
use AppBundle\Entity\Animaux;
use AppBundle\Entity\User;
use AppBundle\Event\AnimalEvent;
use AppBundle\EventListener\AnimalSubscriber;
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
        $form = $this->createForm('AppBundle\Form\AnimauxType', $animaux, array(
            'validation_groups' => array('create')));
        if($request->getMethod()=== "POST") {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $animalEvent = $this->get('app.event.animal');
                $animalEvent -> setAnimal($animaux);
                $dispatcher = $this->get('event_dispatcher');
                $dispatcher-> dispatch(GlobalEvents::ANIMAL_ADD, $animalEvent);
                return $this->redirectToRoute('animaux_show', array('id' => $animalEvent->getAnimal()->getId()));
            }
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
        $editForm = $this->createForm('AppBundle\Form\AnimauxType', $animaux, array(
            'method' => "PUT"));
        if($request->getMethod()=== "PUT") {
            $editForm->handleRequest($request);
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $animalEvent = $this->get('app.event.animal');
                $animalEvent->setAnimal($animaux);
                $dispatcher = $this->get('event_dispatcher');
                $dispatcher->dispatch(GlobalEvents::ANIMAL_UPDATE, $animalEvent);

                return $this->redirectToRoute('animaux_show', array('id' => $animalEvent->getAnimal()->getId()));
            }
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
        $form = $this->createForm('AppBundle\Form\AccouplementType');
        if($request->getMethod() === "POST") {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $accouplementEvent = $this->get('app.event.accouplement');
                $accouplementEvent->setData($form->getData());
                $dispatcher = $this->get('event_dispatcher');
                $dispatcher->dispatch(GlobalEvents::ACCOUPLEMENT, $accouplementEvent);
            } // FORM
        } // POST
        return $this->render('animaux/accouplement.html.twig',  array(
            'accouplement_form' => $form->createView()));
        }
}