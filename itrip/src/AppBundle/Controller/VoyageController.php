<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Voyage;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Agenda;
use AppBundle\Entity\MoneyPot;
use AppBundle\Entity\Utilisateur_Voyage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Voyage controller.
 *
 * @Route("user/voyage")
 */
class VoyageController extends Controller
{
    /**
     * Lists all voyage entities.
     *
     * @Route("/", name="voyage_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $voyages = $em->getRepository('AppBundle:Voyage')->findAll();

        return $this->render('voyage/index.html.twig', array(
            'voyages' => $voyages,
        ));
    }

    /**
     * Creates a new voyage entity.
     *
     * @Route("/new", name="voyage_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request,  UserInterface $user)
    {
        $voyage = new Voyage();
        $form = $this->createForm('AppBundle\Form\VoyageType', $voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($voyage);
            $em->flush();

            $mp = new MoneyPot();
            $mp->setValue(0);
            $em->persist($mp);
            $em->flush();

            $ag = new Agenda();
            $ag->setDateDebut($form->get('dateDebut')->getData());
            $ag->setDateFin($form->get('dateFin')->getData());
            $em->persist($ag);
            $em->flush();


            $voyage->setIdMoneyPot( $mp->getId());
            $voyage->setIdAgenda( $ag->getId());
            $voyage->setIsActif(1);
            $em->persist($voyage);
            $em->flush();

            $av = new Utilisateur_Voyage();
            $av->setIdUtilisateur($user->getId());
            $av->setIdVoyage($voyage->getId());
            $av->setIsCreator(1);
            $em->persist($av);
            $em->flush();

           

            return $this->redirectToRoute('voyage_show', array('id' => $voyage->getId()));
        }

        return $this->render('voyage/new.html.twig', array(
            'voyage' => $voyage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a voyage entity.
     *
     * @Route("/{id}", name="voyage_show")
     * @Method("GET")
     */
    public function showAction(Voyage $voyage, UserInterface $user)
    {
        $deleteForm = $this->createDeleteForm($voyage);
        $em = $this->getDoctrine()->getManager();


        $participants = $em->getRepository('AppBundle:Voyage')->findUserByVoyage($voyage->getId());
        $agenda = $em->getRepository('AppBundle:Agenda')->find($voyage->getIdAgenda());
        $money_pot = $em->getRepository('AppBundle:MoneyPot')->find($voyage->getIdMoneyPot());
        $creator = $em->getRepository('AppBundle:Utilisateur')->findCreator($voyage->getId());
        $activities = $em->getRepository('AppBundle:Agenda')->findActivitiesByAgendaId($voyage->getIdAgenda());
        $comments = $em->getRepository('AppBundle:Voyage')->findCommentsByVoyageId($voyage->getId());
        $user_activite = array();
        foreach($activities as $activite){

            $user_activite[$activite['id']] = $em->getRepository('AppBundle:Activite')->findUtilisateursByActivite($activite['id']); 
        }
        

        if($user->getId() == $creator[0]['id']){
            $isCreator = true;
        }else{
            $isCreator = false;
        }

        return $this->render('voyage/show.html.twig', array(
            'voyage' => $voyage,
            'participants' => $participants,
            'moneyPot' => $money_pot,
            'activities' => $activities,
            'creator' => $creator[0],
            'agenda' => $agenda,
            'isCreator' => $isCreator,
            'comments' => $comments,
            'user_activite' => $user_activite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing voyage entity.
     *
     * @Route("/{id}/edit", name="voyage_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Voyage $voyage)
    {
        $deleteForm = $this->createDeleteForm($voyage);
        $editForm = $this->createForm('AppBundle\Form\VoyageType', $voyage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('voyage_edit', array('id' => $voyage->getId()));
        }

        return $this->render('voyage/edit.html.twig', array(
            'voyage' => $voyage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a voyage entity.
     *
     * @Route("/{id}", name="voyage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Voyage $voyage)
    {
        $form = $this->createDeleteForm($voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($voyage);
            $em->flush();
        }

        return $this->redirectToRoute('voyage_index');
    }

    /**
     * Creates a form to delete a voyage entity.
     *
     * @param Voyage $voyage The voyage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Voyage $voyage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('voyage_delete', array('id' => $voyage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
