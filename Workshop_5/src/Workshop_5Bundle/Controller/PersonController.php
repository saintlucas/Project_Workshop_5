<?php

namespace Workshop_5Bundle\Controller;

use Workshop_5Bundle\Entity\Person;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;



use Workshop_5Bundle\Form\PersonType;
use Workshop_5Bundle\Form\AddresType;
use Workshop_5Bundle\Form\PhoneType;
use Workshop_5Bundle\Form\EmailType;
use Workshop_5Bundle\Form\GroupsType;

/**
 * Person controller.
 *
 * @Route("/person")
 */
class PersonController extends Controller {

    /**
     * @Route("/newPerson")
     * @Template("Workshop_5Bundle:person:newPerson.html.twig")
     */
    public function newPersonAction(Request $request) {

        $newPerson = new Person;

        $form = $this->createFormBuilder($newPerson)
                ->add('name', 'text')
                ->add('surname', 'text')
                ->add('description', 'text')
                ->add('save', 'submit', array('label' => 'Dodaj nową osobę'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $person = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            $url = $this->generateUrl('person_index');

            return $this->redirect($url);
        }
        return array('form' => $form->createView());
    }

    
    
    /**
     * Lists all person entities.
     *
     * @Route("/", name="person_index")
     */
    public function indexAction(Request $request) {
        
        $em = $this->getDoctrine()->getManager();
        $newPerson = new Person;
        
        $newPersonForm = $this->createForm(new PersonType(), $newPerson)
                ->add('save', 'submit', array('label' => 'Dodaj nową osobę'));
        
        $searchPersonForm = $this->createFormBuilder()
                ->add('name', 'text')
                ->add('save', 'submit', array('label' => 'Znajdź osobę'))
                ->getForm();
        
        $searchPersonForm->handleRequest($request);
        
        if ($searchPersonForm->isSubmitted()) {
            $wantedPerson = $searchPersonForm->getData();
            $repository = $this->getDoctrine()->getRepository('Workshop_5Bundle:Person');
            $matchingPerson = $repository->findAPerson($wantedPerson['name']);
            return $this->render('person/searchPerson.html.twig', array('matchingPerson' =>
                        $matchingPerson));
        }
        
        
        $newPersonForm->handleRequest($request);
        
        if ($newPersonForm->isSubmitted()) {
            $person = $newPersonForm->getData();
            $em->persist($person);
            $em->flush();
        }
        
        $people = $em->getRepository('Workshop_5Bundle:Person')->findAll();
        
        usort($people, array("Workshop_5Bundle\Entity\Person", "cmp_obj"));
        
        return $this->render('/person/index.html.twig', ['people' => $people, 'newPersonForm' => $newPersonForm->createView(),
                    'searchPerson' => $searchPersonForm->createView(),
                    ]);
    }
    
    //sortowanie
    static function cmp_obj($a, $b) {
        $al = strtolower($a->name);
        $bl = strtolower($b->name);
        if ($al == $bl) {
            return 0;
        }
        return ($al > $bl) ? +1 : -1;
    
    }


    /**
     * Finds and displays a person entity.
     *
     * @Route("/{id}", name="person_show")
     * @Method("GET")
     */
    public function showAction(Person $person) {
    
        return $this->render('person/showPerson.html.twig', array(
                    'person' => $person
        ));
    }

    /**
     * Displays a form to edit an existing person entity.
     *
     * @Route("/{id}/edit", name="person_edit")
     * @Template("Workshop_5Bundle:person:editPerson.html.twig")
     */
    public function editAction(Request $request, $id) {
        
        $personList = $this->getDoctrine()->getRepository('Workshop_5Bundle:Person');
        
        $i = 0;
        
        $loadedPerson = $personList->findOneById($id);
        
        $editForm = $this->createForm(new PersonType(), $loadedPerson)
                ->add('groups')
                ->add('save', 'submit', array('label' => 'Edytuj osobę'));
        
        $addressForm = $this->createForm(new AddresType());
        $phoneForm = $this->createForm(new PhoneType());
        $emailForm = $this->createForm(new EmailType());
        
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $i++;
        }
        
        $addressForm->handleRequest($request);
        if ($addressForm->isSubmitted() && $addressForm->isValid()) {
            $address = $addressForm->getData();
            
            $validator = $this->get('validator');
            $errors = $validator->validate($address);
            if (count($errors) > 0) {
                return array(
                    'errors' => $errors,
                );
            } else {
                $address->setPerson($loadedPerson);
                $em = $this->getDoctrine()->getManager();
                $em->persist($address);
                $em->flush();
                $i++;
            }
        }
        
        $phoneForm->handleRequest($request);
        if ($phoneForm->isSubmitted() && $phoneForm->isValid()) {
            $phone = $phoneForm->getData();
            
            $validator = $this->get('validator');
            $errors = $validator->validate($phone);
            if (count($errors) > 0) {
                return array(
                    'errors' => $errors,
                );
            } else {
                $phone->setPerson($loadedPerson);
                $em = $this->getDoctrine()->getManager();
                $em->persist($phone);
                $em->flush();
                $i++;
            }
        }
        
        $emailForm->handleRequest($request);
        if ($emailForm->isSubmitted() && $emailForm->isValid()) {
            $email = $emailForm->getData();
            
            $validator = $this->get('validator');
            $errors = $validator->validate($email);
            if (count($errors) > 0) {
                return array(
                    'errors' => $errors,
                );
            } else {
                $email->setPerson($emailForm);
                $em = $this->getDoctrine()->getManager();
                $em->persist($email);
                $em->flush();
                $i++;
            }
        }
        if ($i > 0) {
            return $this->redirectToRoute('person_show', array('id' => $id));
        }
        return ['editForm' => $editForm->createView(), 'addressForm' => $addressForm->createView(),
            'phoneForm' => $phoneFrom->createView(), 'emailForm' => $emailForm->createView(),
            ];
    }

    /**
     * Deletes a person entity.
     *
     * @Route("/{id}", name="person_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id) {
        
        $$personList = $this->getDoctrine()->getRepository('Workshop_5Bundle:Person');
        
        $personToDelete = $personList->find($id);
        
        if (!$personToDelete) {
            return new Response('Brak osoby o podanym id');
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($personToDelete);
            $em->flush();
            
            return new Response('<div>Osoba zaostała skasowana<div>
                    <div><a href="/../../person/">Powrót</a></div>'
            );
        }
    }
}