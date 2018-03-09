<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Agenda;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Agenda controller.
 *
 * @Route("agenda")
 */
class AgendaController extends Controller
{
    /**
     * Lists all agenda entities.
     *
     * @Route("/", name="agenda_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $agendas = $em->getRepository('AppBundle:Agenda')->findAll();

        return $this->render('agenda/index.html.twig', array(
            'agendas' => $agendas,
        ));
    }

    /**
     * Finds and displays a agenda entity.
     *
     * @Route("/{id}", name="agenda_show")
     * @Method("GET")
     */
    public function showAction(Agenda $agenda)
    {

        return $this->render('agenda/show.html.twig', array(
            'agenda' => $agenda,
        ));
    }
}
