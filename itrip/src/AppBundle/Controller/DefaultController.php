<?php

namespace AppBundle\Controller;
use AppBundle\Entity;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Activite;
use AppBundle\Entity\Activite_Pack;
use AppBundle\Entity\Activite_Agenda;
use AppBundle\Entity\Agenda;
use AppBundle\Entity\Commentaire;
use AppBundle\Entity\Location;
use AppBundle\Entity\MoneyPot;
use AppBundle\Entity\Notation;
use AppBundle\Entity\Pack;
use AppBundle\Entity\Partenaire;
use AppBundle\Entity\Transaction;
use AppBundle\Entity\Utilisateur_Voyage;
use AppBundle\Entity\Voyage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class DefaultController extends Controller
{

    

    /**
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request)
    {
        $loc = $request->query->get('loc');
        $em = $this->getDoctrine()->getManager();

        $packs = $em->getRepository('AppBundle:Pack')->findBy( ['nom' =>  $loc]);

        return $this->render('pack/index.html.twig', array(
            'packs' => $packs,
        ));
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('default/index.html.twig', [
            "packs"=> $em->getRepository('AppBundle:Pack')->findAll(),
        ]);
    }

    /**
     * @Route("/init", name="init")
     */
    public function init()
    {
        $em = $this->getDoctrine()->getManager();

        $user_1 = new Utilisateur();
        $user_1->setNom('user1_nom');
        $user_1->setPrenom('user1_prenom');
        $user_1->setMail('user1');
        $user_1->setMdp('user1');
        //$user_1->setIsAdmin('false');
        $user_1->setIsAdmin(0);
        $user_1->setIsPartenaire(0);

        $user_2 = new Utilisateur();
        $user_2->setNom('admin');
        $user_2->setPrenom('admin');
        $user_2->setMail('root');
        $user_2->setMdp('root');
        //$user_2->setIsAdmin('true');
        $user_2->setIsAdmin(1);
        $user_2->setIsPartenaire(0);

        $location = new Location();
        $location->setNom('Marrakech');
        $location->setDescription('location description 1');

        $activite = new Activite();
        $activite->setDescription('activite description 1');
        $activite->setNom('activite1_nom');
        $activite->setIdLoc(1);

        $agenda = new Agenda();
        $agenda->setDateDebut(date_create(date("Y-m-d H:i:s")));
        $agenda->setDateFin(date_create(date("Y-m-d H:i:s")));

        $mp = new MoneyPot();
        $mp->setValue(0);
       
        $voyage_1 = new Voyage();
        $voyage_1->setNom('voyage1_nom');
        $voyage_1->setIdLocation(1);
        $voyage_1->setIdAgenda(1);
        $voyage_1->setIdMoneyPot(1);
        $voyage_1->setIsActif(1);
        //$voyage_1->setIsActif(true);

        $partenaire_1 = new Partenaire();
        $partenaire_1->setNom('partenaire1_nom');
        

        $pack_1 = new Pack();
        $pack_1->setPrix(1000);
        $pack_1->setDateDebut(date_create(date("Y-m-d H:i:s")));
        $pack_1->setDateFin(date_create(date("Y-m-d H:i:s")));
        $pack_1->setNom('pack1');
        $pack_1->setDescription('pack1 description');
        $pack_1->setNbPersonne(3);
        $pack_1->setIdPartenaire(1);
        $pack_1->setIdLoc(1);
        $pack_1->setLien('https://www.tripadvisor.com/');

        $pack_2 = new Pack();
        $pack_2->setPrix(1000);
        $pack_2->setDateDebut(date_create(date("Y-m-d H:i:s")));
        $pack_2->setDateFin(date_create(date("Y-m-d H:i:s")));
        $pack_2->setNom('pack2');
        $pack_2->setDescription('pack2 description');
        $pack_2->setNbPersonne(3);
        $pack_2->setIdPartenaire(1);
        $pack_2->setIdLoc(1);
        $pack_2->setLien('https://www.tripadvisor.com/');
        $pack_2->setIdPart(1);

        $notation_1=new Notation();
        $notation_1->setIdUtilisateur(1);
        $notation_1->setIdPack(1);
        $notation_1->setNote(3);
        $notation_1->setDate(date_create(date("Y-m-d H:i:s")));
        $notation_1->setCommentaire('bullshit');

        $notation_2=new Notation();
        $notation_2->setIdUtilisateur(2);
        $notation_2->setIdPack(1);
        $notation_2->setNote(2);
        $notation_2->setDate(date_create(date("Y-m-d H:i:s")));
        $notation_2->setCommentaire('bullshit2');

        $notation_3=new Notation();
        $notation_3->setIdUtilisateur(1);
        $notation_3->setIdPack(2);
        $notation_3->setNote(5);
        $notation_3->setDate(date_create(date("Y-m-d H:i:s")));
        $notation_3->setCommentaire('very good');

        $commentaire = new Commentaire();
        $commentaire->setIdUtilisateur(1);
        $commentaire->setIdVoyage(1);
        $commentaire->setMessage('commentaire 1');
        $commentaire->setDateCommentaire(date_create(date("Y-m-d H:i:s")));

        $transaction = new Transaction();
        $transaction->setIdUtilisateur(1);
        $transaction->setValeur(300);
        $transaction->setDateTransaction(date_create(date("Y-m-d H:i:s")));
        $transaction->setIdMoneyPot(1);

        $activite_pack = new Activite_Pack();
        $activite_pack->setIdActivite(1);
        $activite_pack->setIdPack(1);

        $user_voyage = new Utilisateur_Voyage();
        $user_voyage->setIdUtilisateur(1);
        $user_voyage->setIdVoyage(1);

        $activite_agenda = new Activite_Agenda();
        $activite_agenda->setIdUtilisateur(1);
        $activite_agenda->setIdAg(1);
        $activite_agenda->setIdAct(1);
        $activite_agenda->setDate(date_create(date("Y-m-d H:i:s")));

        $em->persist($user_1);
        $em->persist($user_2);
        $em->persist($location);
        $em->persist($activite);
        $em->persist($agenda);
        $em->persist($voyage_1);
        $em->persist($partenaire_1);
        $em->persist($pack_1);
        $em->persist($pack_2);
        $em->persist($notation_1);
        $em->persist($notation_2);
        $em->persist($notation_3);
        $em->persist($commentaire);
        $em->persist($mp);
        $em->persist($transaction);
        $em->persist($activite_pack);
        $em->persist($user_voyage);
        $em->persist($activite_agenda);

        $em->flush();

        return $this->redirectToRoute('homepage');

    }

    /**
     * @Route("/clean", name="clean")
     */
    public function clean()
    {
        $em = $this->getDoctrine()->getManager();
        $tab = array();
        $tab['users'] = $em->getRepository('AppBundle:Utilisateur')->findAll();
        $tab['voyages'] = $em->getRepository('AppBundle:Voyage')->findAll();
        $tab['activites'] = $em->getRepository('AppBundle:Activite')->findAll();
        $tab['commentaires'] = $em->getRepository('AppBundle:Commentaire')->findAll();
        $tab['locations']  = $em->getRepository('AppBundle:Location')->findAll();
        $tab['partenaires'] = $em->getRepository('AppBundle:Partenaire')->findAll();
        $tab['packs'] = $em->getRepository('AppBundle:Pack')->findAll();
        $tab['transactions'] = $em->getRepository('AppBundle:Transaction')->findAll();
        $tab['agendas'] = $em->getRepository('AppBundle:Agenda')->findAll();
        $tab['notations'] = $em->getRepository('AppBundle:Notation')->findAll();
        $tab['moneypots'] = $em->getRepository('AppBundle:MoneyPot')->findAll();
        $tab['utilisateur_voyages'] = $em->getRepository('AppBundle:Utilisateur_Voyage')->findAll();
        $tab['activite_agenda'] = $em->getRepository('AppBundle:Activite_Agenda')->findAll();
        $tab['activite_pack'] = $em->getRepository('AppBundle:Activite_Pack')->findAll();

        foreach($tab as $key => $value){
            foreach($value as $row){
                $em->remove($row);
            }
        }

        $em->flush();

        $tab_ai = array(
            'AppBundle:Utilisateur', 
            'AppBundle:Voyage', 
            'AppBundle:Activite', 
            'AppBundle:Commentaire',
            'AppBundle:Location',
            'AppBundle:Partenaire',
            'AppBundle:Pack',
            'AppBundle:Transaction',
            'AppBundle:MoneyPot',
            'AppBundle:Agenda',
            'AppBundle:Notation',
            'AppBundle:Utilisateur_Voyage',
            'AppBundle:Activite_Agenda',
            'AppBundle:Activite_Pack',
        );
        foreach($tab_ai as $name){
            $tableName = $em->getClassMetadata($name)->getTableName();
            $connection = $em->getConnection();
            $connection->exec("ALTER TABLE " . $tableName . " AUTO_INCREMENT = 1;");
        }
        

        

        return $this->redirectToRoute('homepage');

    }



}
