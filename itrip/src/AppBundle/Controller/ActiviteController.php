<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Activite;
use AppBundle\Entity\Voyage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Activite_Agenda;
/**
 * Activite controller.
 *
 * @Route("activite")
 */
class ActiviteController extends Controller
{
    /**
     * Lists all activite entities.
     *
     * @Route("/", name="activite_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $activites = $em->getRepository('AppBundle:Activite')->findAll();

        return $this->render('activite/index.html.twig', array(
            'activites' => $activites,
        ));
    }

    /**
     * Creates a new activite entity.
     *
     * @Route("/new/{idAgenda}", name="activite_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $idAgenda)
    {

        $em = $this->getDoctrine()->getManager();
        $idLocation = $em->getRepository('AppBundle:Voyage')->findOneBy(
            ['idAgenda' =>  $idAgenda]
        )->getIdLocation();


        $activite = new Activite();
        $activite->setIdLoc($idLocation);
        
       
        $idVoyage = $em->getRepository('AppBundle:Voyage')->findOneBy(
            ['idAgenda' =>  $idAgenda]
        )->getId();
        

        $form = $this->createForm('AppBundle\Form\ActiviteType', $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($activite);
            
            $em->flush();
            
            $act_ag = new Activite_Agenda();
            $act_ag->setIdActivite($activite->getId());
            $act_ag->setIdAgenda($idAgenda);
            $em->persist($act_ag);
            $em->flush();

            
       

            return $this->redirectToRoute('voyage_show', array('id' => $idVoyage));
        }

        return $this->render('activite/new.html.twig', array(
            'activite' => $activite,
            'idVoyage' => $idVoyage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a activite entity.
     *
     * @Route("/{id}", name="activite_show")
     * @Method("GET")
     */
    public function showAction(Activite $activite)
    {
        $deleteForm = $this->createDeleteForm($activite);

        return $this->render('activite/show.html.twig', array(
            'activite' => $activite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing activite entity.
     *
     * @Route("/{id}/{idVoyage}/edit", name="activite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Activite $activite, $idVoyage)
    {
        $deleteForm = $this->createDeleteForm($activite);
        $editForm = $this->createForm('AppBundle\Form\ActiviteType', $activite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('voyage_show', array('id' => $idVoyage));
        }

        return $this->render('activite/edit.html.twig', array(
            'activite' => $activite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a activite entity.
     *
     * @Route("/{id}", name="activite_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Activite $activite)
    {
        $form = $this->createDeleteForm($activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($activite);
            $em->flush();
        }

        return $this->redirectToRoute('activite_index');
    }

    /**
     * Creates a form to delete a activite entity.
     *
     * @param Activite $activite The activite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Activite $activite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('activite_delete', array('id' => $activite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * 
     *
     * @Route("/removeA/{idActivite}/{idAgenda}/{idVoyage} ", name="removeActiviteFromAgenda")
     * @Method({"GET", "POST", "DELETE"})
     */
    public function removeActiviteFromAgenda($idActivite, $idAgenda, $idVoyage ){

        $em = $this->getDoctrine()->getManager();
        
        $aa = $em->getRepository('AppBundle:Activite_Agenda')->findOneBy(
                ['idActivite' => $idActivite,
                'idAgenda' =>  $idAgenda ]
            );
        $em->remove($aa);
        $em->flush();
        
        return $this->redirectToRoute('voyage_show', array('id' => $idVoyage));
    }
    /**
     * 
     *
     * @Route("/addUtoAc/{idActivite}/{idAgenda}", name="addUtilisateurToActivite")
     * @Method({"GET", "POST"})
     */
    public function addUtilisateurToActivite( $idActivite, $idAgenda){
        $em = $this->getDoctrine()->getManager();

        $idVoyage = $em->getRepository('AppBundle:Voyage')->findOneBy(
            ['idAgenda' =>  $idAgenda ]
        )->getId();

        $utilisateurs = $em->getRepository('AppBundle:Voyage')->findUserByVoyage($idVoyage);

        return $this->render('voyage/addUtilisateurToAct.html.twig', array(
            'utilisateurs' => $utilisateurs,
            'idActivite' => $idActivite,
            'idAgenda' => $idAgenda,

        ));
    }
    /**
     * 
     *
     * @Route("/addUtoAcA/{idUtilisateur}/{idActivite}/{idAgenda}", name="addUtilisateurToActiviteAction")
     * @Method({"GET", "POST"})
     */
    public function addUtilisateurToActiviteAction($idUtilisateur, $idActivite, $idAgenda){
        $em = $this->getDoctrine()->getManager();

        $aa = new Activite_Agenda();
        $aa->setIdAgenda($idAgenda);
        $aa->setIdActivite($idActivite);
        $aa->setIdUtilisateur($idUtilisateur);

        $em->persist($aa);
        $em->flush();

        $idVoyage = $em->getRepository('AppBundle:Voyage')->findOneBy(
            ['idAgenda' =>  $idAgenda ]
        )->getId();
        return $this->redirectToRoute('voyage_show', array('id' => $idVoyage));
    }

}
