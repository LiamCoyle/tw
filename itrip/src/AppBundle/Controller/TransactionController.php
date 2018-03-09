<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Transaction;use AppBundle\Entity\Voyage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * Transaction controller.
 *
 * @Route("transaction")
 */
class TransactionController extends Controller
{
    /**
     * Lists all transaction entities.
     *
     * @Route("/{idMoneyPot}", name="transaction_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction($idMoneyPot)
    {
        $em = $this->getDoctrine()->getManager();

        $transactions = $em->getRepository('AppBundle:Transaction')->findTransactionUser( $idMoneyPot);

        $idVoyage=$em->getRepository('AppBundle:Voyage')->findOneBy( ['idMoneyPot'=>$idMoneyPot])->getId();
        return $this->render('transaction/index.html.twig', array(
            'transactions' => $transactions,
            'idMoneyPot' => $idMoneyPot,
            'idVoyage' => $idVoyage,
        ));
    }

    /**
     * Creates a new transaction entity.
     *
     * @Route("/new/{idMoneyPot}", name="transaction_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, UserInterface $user, $idMoneyPot)
    {
        $transaction = new Transaction();
        $transaction->setDateTransaction(date_create(date("Y-m-d H:i:s")));
        $transaction->setIdUtilisateur($user->getId());
        $transaction->setIdMoneyPot($idMoneyPot);
        
        $form = $this->createForm('AppBundle\Form\TransactionType', $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($transaction);
            $em->flush();

            $mp = $em->getRepository('AppBundle:MoneyPot')->find( $idMoneyPot);
            $mp->setValue($mp->getValue() + $transaction->getValeur());
            $em->persist($mp);
            $em->flush();
            

            return $this->redirectToRoute('transaction_index', array('idMoneyPot' => $idMoneyPot));
        }

        return $this->render('transaction/new.html.twig', array(
            'transaction' => $transaction,
            'idMoneyPot' => $idMoneyPot,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a transaction entity.
     *
     * @Route("/{id}", name="transaction_show")
     * @Method("GET")
     */
    public function showAction(Transaction $transaction)
    {
        $deleteForm = $this->createDeleteForm($transaction);

        return $this->render('transaction/show.html.twig', array(
            'transaction' => $transaction,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing transaction entity.
     *
     * @Route("/{id}/edit", name="transaction_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Transaction $transaction)
    {
        $deleteForm = $this->createDeleteForm($transaction);
        $editForm = $this->createForm('AppBundle\Form\TransactionType', $transaction);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transaction_edit', array('id' => $transaction->getId()));
        }

        return $this->render('transaction/edit.html.twig', array(
            'transaction' => $transaction,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a transaction entity.
     *
     * @Route("/{id}", name="transaction_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Transaction $transaction)
    {
        $form = $this->createDeleteForm($transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($transaction);
            $em->flush();
        }

        return $this->redirectToRoute('transaction_index');
    }

    /**
     * Creates a form to delete a transaction entity.
     *
     * @param Transaction $transaction The transaction entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Transaction $transaction)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('transaction_delete', array('id' => $transaction->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
