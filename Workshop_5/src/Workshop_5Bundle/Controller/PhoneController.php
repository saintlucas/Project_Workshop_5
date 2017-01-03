<?php

namespace Workshop_5Bundle\Controller;

use Workshop_5Bundle\Entity\Phone;
use Workshop_5Bundle\Entity\Person;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Phone controller.
 *
 * @Route("phone")
 */
class PhoneController extends Controller {

    /**
     * @Route("/addPhoneNumber/{id}")
     * @Template("Workshop_5Bundle:Phone:newPhone.html.twig") 
     */
    public function addPhoneNumberAction(Request $request, $id) {

        $newPhoneNumber = new Phone;

        $form = $this->createFormBuilder($newPhoneNumber)
                ->add('phone_number', 'number')
                ->add('type', ChoiceType::class, array(
                    'choices' => array(
                        'Domowy' => 'domowy',
                        'Służbowy' => 'służbowy',
                    )
                ))
                ->add('save', 'submit', array('label' => 'Dodaj numer telefonu'))
                ->getForm();

        $personList = $this->getDoctrine()->getRepository('Workshop_5Bundle:Person');

        $loadedPerson = $personList->findOneById($id);

        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $newPhoneNumber = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($newPhoneNumber);
            $em->flush();

            $url = $this->generateUrl('person_show', array('id' => $id));

            return $this->redirect($url);
        }
        return array('form' => $form->createView());
    }

    /**
     * Lists all phone entities.
     *
     * @Route("/", name="phone_index")
     * @Method("GET")
     */
    public function indexAction() {
        
        $em = $this->getDoctrine()->getManager();

        $phones = $em->getRepository('Workshop_5Bundle:Phone')->findAll();

        return $this->render('phone/indexPhone.html.twig', array(
                    'phones' => $phones,
        ));
    }

    /**
     * Finds and displays phone entity.
     *
     * @Route("/{id}", name="phone_show")
     * @Method("GET")
     */
    public function showAction(Phone $phone) {
        return $this->render('phone/showPhone.html.twig', array(
                    'phone' => $phone,
        ));
    }

}