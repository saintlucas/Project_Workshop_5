<?php

namespace Workshop_5Bundle\Controller;

use Workshop_5Bundle\Entity\Groups;
use Workshop_5Bundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Groups controller.
 *
 * @Route("groups")
 */
class GroupsController extends Controller {

    /**
     * @Route("/addGroup")
     * @Template("Workshop_5Bundle:Groups:newGroup.html.twig")
     */
    public function addGroup(Request $request) {

        $newGroup = new Groups;
        
        $form = $this->createFormBuilder($newGroup)
                ->add('name', 'text')
                ->add('save', 'submit', array('label' => 'Dodaj grupę'))
                ->getForm();

        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $group = $form->getData();

            $em->persist($group);
            $em->flush();
            $url = $this->generateUrl('groups_index');
            return $this->redirect($url);
        }

        $allGroups = $em->getRepository('Workshop_5Bundle:Groups')->findAll();
        return array('form' => $form->createView(), 'allGroups' => $allGroups);
    }

    /**
     * Lists all Groups entities.
     *
     * @Route("/", name="groups_index")
     * @Method("GET")
     */
    public function indexAction() {
        
        $em = $this->getDoctrine()->getManager();

        $allGroups = $em->getRepository('Workshop_5Bundle:Groups')->findAll();
        
        return $this->render('groups/indexGroups.html.twig', array(
                    'allGroups' => $allGroups,
        ));
    }
    
    
    /**
     * Finds and displays a Groups entity.
     *
     * @Route("/{id}", name="groups_show")
     * @Method("GET")
     */
    public function showAction(Groups $groups)
    {
        
        return $this->render('Workshop_5Bundle:Groups:showGroup.html.twig', ['groups' => $groups,
            ]);
    }

}