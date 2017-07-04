<?php

namespace SoftUniBundle\Controller;

use SoftUniBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     * @Route("admin/product/", name="admin_product_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $products = $this->get("app.product_manager")->getAll();
        return $this->render('SoftUniBundle:product:index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Lists all productCategory entities.
     *
     * @Route("product/list", name="product_list_ord_by_rank")
     * @Method("GET")
     */
    public function listAction()
    {
        $product = $this->get("app.product_manager")->getAllOrderedByRang();

        return $this->render('SoftUniBundle:product:product-list.html.twig', array(
            'products' => $product,
        ));
    }

    /**
     * Creates a new product entity.
     *
     * @Route("admin/product/new", name="admin_product_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('SoftUniBundle\Form\ProductType', $product);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

//            $product ->setCreatedAt(new \DateTime());
//            $product ->setUpdatedAt(new \DateTime());
//
//            $file = $product->getPicture();
//            $fileName = $this->get('app.product_pic_uploader')->upload($file);
//
//            $product->setPicture($fileName);
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($product);
//            $em->flush();

            $this->get('app.product_manager')->createProduct($product);
            $this->get('app.email_sender')->sendEmailNewProduct($product);

            return $this->redirectToRoute('product_list_ord_by_rank', array('id' => $product->getId()));
        }

        return $this->render('SoftUniBundle:product:new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("admin/product/{id}", name="admin_product_show")
     * @Method("GET")
     */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('SoftUniBundle:product:show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("admin/product/{id}/edit", name="admin_product_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('SoftUniBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $product->setUpdatedAt(new \DateTime());


            $file = $product->getPicture();
            $fileName = $this->get('app.product_pic_uploader')->update($file, $product->getId());

            $product->setPicture($fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_product_edit', array('id' => $product->getId()));
        }

        return $this->render('SoftUniBundle:product:edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a product entity.
     *
     * @Route("admin/product/{id}", name="admin_product_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->get("app.product_manager")->removeProduct($product);
        }

        return $this->redirectToRoute('admin_product_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
