<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Pack;
use AppBundle\Entity\Voyage;
use AppBundle\Entity\Utilisateur_Voyage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * Utilisateur controller.
 *
 * @Route("user/utilisateur")
 */
class UtilisateurController extends Controller
{   


    
    /**
     *
     * @Route("/", name="user_homepage")
     * 
     */
    public function homepageAction(UserInterface $user)
    {
        $em = $this->getDoctrine()->getManager();

        $voyages = $em->getRepository('AppBundle:Voyage')->findVoyageByUser($user->getId());
        
        //$voyages = $em->getRepository('AppBundle:Voyage')->findBy( ['idUt' =>  $idAgenda]);
        $packs = $em->getRepository('AppBundle:Pack')->findAll();
        
        
        if($user->getIsAdmin()){
            // a modifé pour admin
            return $this->render('utilisateur/user_homepage.html.twig', array(
                'voyages' => $voyages,
                'packs' => $packs,
            ));
        }

        return $this->render('utilisateur/user_homepage.html.twig', array(
            'voyages' => $voyages,
            'packs' => $packs,
        ));
       
    }
    /**
     * @Route("/admin", name="admin_homepage")
     */
    public function adminAction()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }

    /**
     * Lists all utilisateur entities.
     *
     * @Route("/", name="utilisateur_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $utilisateurs = $em->getRepository('AppBundle:Utilisateur')->findAll();

        return $this->render('utilisateur/index.html.twig', array(
            'utilisateurs' => $utilisateurs,
        ));
    }

    /**
     * Creates a new utilisateur entity.
     *
     * @Route("/new", name="utilisateur_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm('AppBundle\Form\UtilisateurType', $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();

            return $this->redirectToRoute('utilisateur_show', array('id' => $utilisateur->getId()));
        }

        return $this->render('utilisateur/new.html.twig', array(
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a utilisateur entity.
     *
     * @Route("/{id}", name="utilisateur_show")
     * @Method("GET")
     */
    public function showAction(Utilisateur $utilisateur)
    {
        $deleteForm = $this->createDeleteForm($utilisateur);

        return $this->render('utilisateur/show.html.twig', array(
            'utilisateur' => $utilisateur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing utilisateur entity.
     *
     * @Route("/{id}/edit", name="utilisateur_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Utilisateur $utilisateur)
    {
        $deleteForm = $this->createDeleteForm($utilisateur);
        $editForm = $this->createForm('AppBundle\Form\UtilisateurType', $utilisateur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('utilisateur_edit', array('id' => $utilisateur->getId()));
        }

        return $this->render('utilisateur/edit.html.twig', array(
            'utilisateur' => $utilisateur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a utilisateur entity.
     *
     * @Route("/{id}", name="utilisateur_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Utilisateur $utilisateur)
    {
        $form = $this->createDeleteForm($utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($utilisateur);
            $em->flush();
        }

        return $this->redirectToRoute('utilisateur_index');
    }

    /**
     * Creates a form to delete a utilisateur entity.
     *
     * @param Utilisateur $utilisateur The utilisateur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Utilisateur $utilisateur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('utilisateur_delete', array('id' => $utilisateur->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * 
     *
     * @Route("/add/{idVoyage}", name="addUtilisateurToTrip")
     * @Method({"GET", "POST"})
     */
    public function addToTripSearch($idVoyage){

        $em = $this->getDoctrine()->getManager();
        $utilisateurs = $em->getRepository('AppBundle:Utilisateur')->findAll();
        return $this->render('voyage/addUtilisateurToTrip.html.twig', array(
            'utilisateurs' => $utilisateurs,
            'idVoyage' => $idVoyage,
        ));
    }


     /**
     * 
     *
     * @Route("/addUserToTrip/{idUtilisateur}/{idVoyage}", name="addUtilisateurToPartipants")
     * @Method({"GET", "POST"})
     */
    public function addUtilisateurToPartipants($idUtilisateur, $idVoyage){

        $em = $this->getDoctrine()->getManager();
        $uv = new Utilisateur_Voyage();
        $uv->setIdUtilisateur($idUtilisateur);
        $uv->setIdVoyage($idVoyage);
        $uv->setIsCreator(0);

        $em->persist($uv);
        $em->flush();
        return $this->redirectToRoute('voyage_show', array('id' => $idVoyage));
    }


       /**
     * 
     *
     * @Route("/remove/{idUtilisateur}/{idVoyage}", name="removeFromTrip")
     * @Method({"GET", "POST", "DELETE"})
     */
    public function removeFromTrip($idUtilisateur, $idVoyage){

        $em = $this->getDoctrine()->getManager();
        //$uv = $em->getRepository('AppBundle:Utilisateur_Voyage')->findByUtilisateurAndVoyage($idUtilisateur, $idVoyage);
        $uv = $em->getRepository('AppBundle:Utilisateur_Voyage')->findOneBy(
                ['idUtilisateur' => $idUtilisateur,
                'idVoyage' =>  $idVoyage]
            );
        $em->remove($uv);
        $em->flush();
        
        return $this->redirectToRoute('voyage_show', array('id' => $idVoyage));
    }

     /**
     * 
     *
     * @Route("/removeU/{idUtilisateur}/{idActivite}/{idVoyage} ", name="removeUtilisateurFromActivite")
     * @Method({"GET", "POST", "DELETE"})
     */
    public function removeUtilisateurFromActivite($idUtilisateur, $idActivite, $idVoyage){
        $em = $this->getDoctrine()->getManager();
        
        $aa = $em->getRepository('AppBundle:Activite_Agenda')->findOneBy(
                ['idUtilisateur' => $idUtilisateur,
                'idActivite' =>  $idActivite,
                ]
            );
        $em->remove($aa);
        $em->flush();
        
        return $this->redirectToRoute('voyage_show', array('id' => $idVoyage));

    }

    
}
