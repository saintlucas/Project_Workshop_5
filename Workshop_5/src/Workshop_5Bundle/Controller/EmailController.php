<?php

namespace Workshop_5Bundle\Controller;

use Workshop_5Bundle\Entity\Email;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Email controller.
 *
 * @Route("email")
 */
class EmailController extends Controller {

    /**
     * @Route("/addEmailNumber/{id}")
     * @Template("Workshop_5Bundle:Addres:newAddres.html.twig") 
     */
    public function addEmailAction(Request $request, $id) {

        $newEmail = new Email;

        $form = $this->createFormBuilder($newEmail)
                ->add('email_address', 'text')
                ->add('type', ChoiceType::class, array(
                    'choices' => array(
                        'Domowy' => 'domowy',
                        'Służbowy' => 'służbowy',
                        'Inny' => 'inny',
                    )
                ))
                ->add('save', 'submit', array('label' => 'Dodaj email'))
                ->getForm();

        $personList = $this->getDoctrine()->getRepository('Workshop_5Bundle:Person');
        $loadedPerson = $personList->findOneById($id);

        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $email = $form->getData();
            $newEmail->setEmailAddress($email->getEmailAddress());
            $newEmail->setType($email->getType());
            $newEmail->setPerson($loadedPerson);

            $em = $this->getDoctrine()->getManager();
            $em->persist($newEmail);
            $em->flush();

            $url = $this->generateUrl('person_show', array('id' => $id));
            return $this->redirect($url);
        }
        return array('form' => $form->createView());
    }

    /**
     * Lists all email entities.
     *
     * @Route("/", name="email_index")
     * @Method("GET")
     */
    public function indexAction() {

        $em = $this->getDoctrine()->getManager();

        $emails = $em->getRepository('Workshop_5Bundle:Email')->findAll();

        return $this->render('email/index.html.twig', array(
                    'emails' => $emails,
        ));
    }

    /**
     * Finds and displays a email entity.
     *
     * @Route("/{id}", name="email_show")
     * @Method("GET")
     */
    public function showEmailAction(Email $email) {
        return $this->render('email/showEmail.html.twig', array(
                    'email' => $email,
        ));
    }

}