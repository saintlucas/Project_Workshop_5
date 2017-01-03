<?php

namespace Workshop_5Bundle\Controller;

use Workshop_5Bundle\Entity\Addres;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * Addres controller.
 *
 * @Route("address")
 */
class AddresController extends Controller {

    /**
     * @Route("/addAddres/{id}")
     * @Template("Workshop_5Bundle:Addres:newAddres.html.twig") 
     */
    public function addAddresAction(Request $request, $id) {

        $newAddress = new Addres;

        $form = $this->createFormBuilder($newAddress)
                ->add('city', 'text')
                ->add('street', 'text')
                ->add('house_number', 'number')
                ->add('appartment_number', 'number')
                ->add('save', 'submit', array('label' => 'Dodaj adres'))
                ->getForm();

        $repository = $this->getDoctrine()->getRepository('Workshop_5Bundle:Person');

        $loadedPerson = $repository->findOneById($id);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $address = $form->getData();
            $newAddress->setCity($address->getCity());
            $newAddress->setStreet($address->getStreet());
            $newAddress->setHouseNumber($address->getHouseNumber());
            $newAddress->setAppartmentNumber($address->getAppartmentNumber());
            $newAddress->setPerson($loadedPerson);

            $em = $this->getDoctrine()->getManager();
            $em->persist($newAddress);
            $em->flush();

            $url = $this->generateUrl('person_show', array('id' => $id));
            return $this->redirect($url);
        }
        return array('form' => $form->createView());
    }

    /**
     * Lists all addres entities.
     *
     * @Route("/", name="addres_index")
     * @Method("GET")
     */
    public function indexAction() {

        $em = $this->getDoctrine()->getManager();

        $addresses = $em->getRepository('Workshop_5Bundle:Addres')->findAll();

        return $this->render('addres/index.html.twig', array(
                    'addresses' => $addresses,
        ));
    }

    /**
     * Finds and displays a address entity.
     *
     * @Route("/{id}", name="address_show")
     * @Method("GET")
     */
    public function showAction(Addres $address) {
        return $this->render('addres/showAddress.html.twig', array(
                    'address' => $address,
        ));
    }

    /**
     * Deletes an addres entity.
     *
     * @Route("/{id}", name="addres_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Addres $address) {

        $form = $this->createDeleteForm($address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($address);
            $em->flush($address);
        }

        return $this->redirectToRoute('addres_index');
    }

    /**
     * Creates a form to delete a addres entity.
     *
     * @param Addres $addres The addre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Addres $address) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('addres_delete', array('id' => $address->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
