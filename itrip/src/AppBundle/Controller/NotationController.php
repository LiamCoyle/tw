<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Notation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Notation controller.
 *
 * @Route("notation")
 */
class NotationController extends Controller
{
    /**
     * Lists all notation entities.
     *
     * @Route("/", name="notation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $notations = $em->getRepository('AppBundle:Notation')->findAll();

        return $this->render('notation/index.html.twig', array(
            'notations' => $notations,
        ));
    }

    /**
     * Creates a new notation entity.
     *
     * @Route("/new", name="notation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $notation = new Notation();
        $form = $this->createForm('AppBundle\Form\NotationType', $notation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notation);
            $em->flush();

            return $this->redirectToRoute('notation_show', array('id' => $notation->getId()));
        }

        return $this->render('notation/new.html.twig', array(
            'notation' => $notation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a notation entity.
     *
     * @Route("/{id}", name="notation_show")
     * @Method("GET")
     */
    public function showAction(Notation $notation)
    {
        $deleteForm = $this->createDeleteForm($notation);

        return $this->render('notation/show.html.twig', array(
            'notation' => $notation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing notation entity.
     *
     * @Route("/{id}/edit", name="notation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Notation $notation)
    {
        $deleteForm = $this->createDeleteForm($notation);
        $editForm = $this->createForm('AppBundle\Form\NotationType', $notation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('notation_edit', array('id' => $notation->getId()));
        }

        return $this->render('notation/edit.html.twig', array(
            'notation' => $notation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a notation entity.
     *
     * @Route("/{id}", name="notation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Notation $notation)
    {
        $form = $this->createDeleteForm($notation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($notation);
            $em->flush();
        }

        return $this->redirectToRoute('notation_index');
    }

    /**
     * Creates a form to delete a notation entity.
     *
     * @param Notation $notation The notation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Notation $notation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notation_delete', array('id' => $notation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
