<?php

namespace SoftUniBundle\Controller;

use SoftUniBundle\Entity\SpamList;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Spamlist controller.
 *
 * @Route("spamlist")
 */
class SpamListController extends Controller
{
    /**
     * Lists all spamList entities.
     *
     * @Route("/", name="spamlist_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $spamLists = $em->getRepository('SoftUniBundle:SpamList')->findAll();

        return $this->render('spamlist/index.html.twig', array(
            'spamLists' => $spamLists,
        ));
    }

    /**
     * Creates a new spamList entity.
     *
     * @Route("/new", name="spamlist_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $spamList = new Spamlist();
        $form = $this->createForm('SoftUniBundle\Form\SpamListType', $spamList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($spamList);
            $em->flush();

            return $this->redirectToRoute('spamlist_show', array('id' => $spamList->getId()));
        }

        return $this->render('spamlist/new.html.twig', array(
            'spamList' => $spamList,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a spamList entity.
     *
     * @Route("/{id}", name="spamlist_show")
     * @Method("GET")
     */
    public function showAction(SpamList $spamList)
    {
        $deleteForm = $this->createDeleteForm($spamList);

        return $this->render('spamlist/show.html.twig', array(
            'spamList' => $spamList,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing spamList entity.
     *
     * @Route("/{id}/edit", name="spamlist_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SpamList $spamList)
    {
        $deleteForm = $this->createDeleteForm($spamList);
        $editForm = $this->createForm('SoftUniBundle\Form\SpamListType', $spamList);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('spamlist_edit', array('id' => $spamList->getId()));
        }

        return $this->render('spamlist/edit.html.twig', array(
            'spamList' => $spamList,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a spamList entity.
     *
     * @Route("/{id}", name="spamlist_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SpamList $spamList)
    {
        $form = $this->createDeleteForm($spamList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($spamList);
            $em->flush();
        }

        return $this->redirectToRoute('spamlist_index');
    }

    /**
     * Creates a form to delete a spamList entity.
     *
     * @param SpamList $spamList The spamList entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SpamList $spamList)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('spamlist_delete', array('id' => $spamList->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
