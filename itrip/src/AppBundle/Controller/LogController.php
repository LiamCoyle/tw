<?php

namespace AppBundle\Controller;

use AppBundle\Entity;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * LogController controller.
 *
 * @Route("login")
 */
class LogController extends Controller
{
    /**
     * @Route("/", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('default/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));


    }
}

?>